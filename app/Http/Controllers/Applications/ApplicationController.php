<?php

namespace App\Http\Controllers\Applications;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\ApplicationBall;
use App\Models\ApplicationCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    public function index()
    {
        $application = Application::query();

        $currentMonthCount = (clone $application)
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();

// Apply filters based on role
        if (Auth::check()) {
            if (Auth::user()->hasRole('admin')) {
                // Admin sees all
            } elseif (Auth::user()->hasRole('teacher')) {
                $application->where('teacher_id', Auth::id());
            } elseif (Auth::user()->hasRole('company-representative')) {
                if (!Auth::user()->userEnterprise) {
                    return $this->errorResponse(
                        'Sizga hali korxona biriktirilmagan. Iltimos, administratorga murojaat qiling.'
                    );
                }
                $application->where('enterprise_id', Auth::user()->userEnterprise->enterprise_id);
            }
        }

// Clone after filtering
        $baseQuery = clone $application;

// Status counts
        $allCount      = (clone $baseQuery)->count();
        $approvedCount = (clone $baseQuery)->where('status', 'approved')->count();
        $pendingCount  = (clone $baseQuery)->where('status', 'pending')->count();

// Pagination
        $perPage = request()->query('pagination', 20);
        $applications = $application->paginate($perPage);

// Response
        return ApplicationResource::collection($applications)->additional([
            'statistics' => [
                'current_month_count' => $currentMonthCount,
                'all_count'      => $allCount,
                'approved_count' => $approvedCount,
                'pending_count'  => $pendingCount,
                'ball'           => 0,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'enterprise_id' => 'required|exists:enterprises,id',
            'direction' => 'required',
            'start_at' => 'required',
            'end_at' => 'required',
            'date' => 'required|date',
            'reason' => 'required|string',
            'plan' => 'required|string',
            'file_reason' => 'required|file|max:1024|mimes:pdf',
            'file_plan' => 'required|file|max:1024|mimes:pdf',
        ]);

        $application = Application::create([
            'enterprise_id' => $request->enterprise_id,
            'teacher_id' => Auth::id(),
            'direction' => $request->direction,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'date' => $request->date,
            'reason' => $request->reason,
            'plan' => $request->plan
        ]);

        foreach (['file_reason' => 'reason', 'file_plan' => 'plan'] as $input => $type) {
            if ($request->hasFile($input)) {
                $filename = Str::random(6) . '_' . time() . '.' . $request->file($input)->getClientOriginalExtension();
                $request->file($input)->storeAs('public/files/applications/', $filename);

                $application->files()->create([
                    'filename' => $filename,
                    'type' => $type,
                    'path' => url('storage/files/applications/' . $filename),
                ]);
            }
        }


        return $this->successResponse('Application created successfully', new ApplicationResource($application));
    }



//    CHECK APPLICATION

    public function checkApplication(Request $request)
    {
        $request->validate([
            'application_id' => [
                'required',
                'exists:applications,id',
                function ($attribute, $value, $fail) {
                    $application = Application::find($value);
                    $enterpriseId = Auth::user()->userEnterprise->enterprise_id;

                    if (!$application) {
                        return $fail('Ariza topilmadi.');
                    }

                    if ($enterpriseId != $application->enterprise_id) {
                        return $fail('Ushbu ariza sizning tashkilotingizga tegishli emas.');
                    }

                    // application_check jadvalida bor-yo'qligini tekshirish
                    $alreadyChecked = DB::table('application_checks')
                        ->where('application_id', $value)
                        ->exists();

                    if ($alreadyChecked) {
                        return $fail('Ushbu ariza allaqachon tekshirilgan.');
                    }
                }
            ],
            'comment' => 'sometimes',
            'status' => 'required|in:approved,rejected',
        ]);

        Application::find($request->application_id)->update([
            'status' => $request->status
        ]);

        ApplicationCheck::create([
            'application_id' => $request->application_id,
            'checked_at' => now(),
            'status' => $request->status,
            'comment' => $request->comment,
            'user_id' => Auth::id(),
        ]);

        return $this->successResponse('Application checked successfully');
    }

    public function uploadReportFile(Request $request)
    {
        $request->validate([
            'application_id' => [
                'required',
                'exists:applications,id',
                function ($attribute, $value, $fail) {
                    $application = Application::find($value);

                    if (!$application) {
                        return $fail('Ushbu ariza topilmadi.');
                    }

                    if ($application->teacher_id != Auth::id()) {
                        $fail('Siz ushbu ariza uchun hisobot faylini yuklashingiz mumkin emas.');
                    }

                    if ($application->status != 'approved') {
                        $fail('Hisobot faylini faqat tasdiqlangan arizalar uchun yuklash mumkin.');
                    }

                    $alreadyUploaded = $application->files()
                        ->where('fileable_id', $application->id)
                        ->where('type', 'report')
                        ->exists();

                    if ($alreadyUploaded) {
                        $fail('Hisobot fayli allaqachon yuklangan!');
                    }
                }
            ],
            'file' => 'required|file|max:1024|mimes:pdf',
        ]);

        $application = Application::find($request->application_id);

        $filename = Str::random(6) . '_' . time() . '.' . $request->file('file')->getClientOriginalExtension();
        $request->file('file')->storeAs('files/applications/', $filename);

        $application->files()->create([
            'filename' => $filename,
            'type' => 'report',
            'path' => url('storage/files/applications/' . $filename),
        ]);

        return $this->successResponse('Hisobot fayli muvaffaqiyatli yuklandi.');
    }

    public function setBall(Request $request)
    {
        $request->validate([
            'application_id' => [
                'required',
                'exists:applications,id',
                function ($attribute, $value, $fail) {
                    $application = Application::find($value);

                    if ($application->enterprise_id != Auth::user()->userEnterprise->enterprise_id) {
                        $fail('Ushbu ariza sizning tashkilotingizga tegishli emas!.');
                    }

                    if ($application->status != 'approved') {
                        $fail('Ball ni faqat qabul qilingan arizalar uchun qoyish mumkin.');
                    }

                    $alreadyUploaded = $application->files()
                        ->where('fileable_id', $application->id)
                        ->where('type', 'report')
                        ->exists();

                    $alreadySetBaled = $application->applicationBall()
                        ->exists();

                    if ($alreadySetBaled) {
                        $fail('Ball allaqachon qo\'yilgan!');
                    }

                    if (!$alreadyUploaded) {
                        $fail('Hisobot fayli yuklangman!');
                    }
                }
            ],
            'ball' => 'required|integer|min:1|max:100',
            'comment' => 'sometimes|string',
        ],[
            'application_id.required' => 'Ariza ID majburiy.',
            'application_id.exists' => 'Ushbu ariza topilmadi.',
            'ball.required' => 'Ball maydoni majburiy.',
            'ball.min' => 'Ball 1 dan kam bo\'lmasligi kerak.',
            'ball.max' => 'Ball 100 dan oshmasligi kerak.',
        ]);
        ApplicationBall::create([
            'application_id' => $request->application_id,
            'ball' => $request->ball,
            'user_id' => Auth::id(),
            'comment' => $request->comment ?? null,
        ]);


        return $this->successResponse('Ball muvaffaqiyatli yuklandi.');
    }
}
