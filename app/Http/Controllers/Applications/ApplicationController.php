<?php

namespace App\Http\Controllers\Applications;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\ApplicationCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    public function index()
    {
        $application = Application::query();

        if (Auth::check()) {
            if (Auth::user()->hasRole('admin')) {
                // Admin bo‘lsa hech qanday filter ishlatilmaydi
                $baseQuery = clone $application;
            } elseif (Auth::user()->hasRole('teacher')) {
                $application->where('teacher_id', Auth::id());
            } elseif (Auth::user()->hasRole('company-representative')) {
                if (!Auth::user()->userEnterprise) {
                    return $this->errorResponse('Sizga hali korxona biriktirilmagan. Iltimos, administratorga murojaat qiling.'); // 400 - Bad Request
                }

                $application->where('enterprise_id', Auth::user()->userEnterprise->id);
            } else {
                $baseQuery = clone $application;
            }
        }

        $allCount      = (clone $baseQuery)->count();
        $approvedCount = (clone $baseQuery)->where('status', 'approved')->count();
        $pendingCount  = (clone $baseQuery)->where('status', 'pending')->count();

        $applications = $application->paginate(request()->query('pagination', 20));

        return ApplicationResource::collection($applications)->additional([
            'statistics' => [
                'all_count'      => $allCount ?? 0,
                'approved_count' => $approvedCount ?? 0,
                'pending_count'  => $pendingCount ?? 0,
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
                    $enterpriseId = Auth::user()->userEnterprise->id;
                    if ($enterpriseId != $application->enterprise_id){
                        return $fail('Ushbu ariza sizning tashkilotingizga tegishli emas.');
                    }
                }
            ],
            'comment' => 'sometimes',
            'status' => 'required|in:approved,rejected',
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
        $request->file('file')->storeAs('public/files/applications/', $filename);

        $application->files()->create([
            'filename' => $filename,
            'type' => 'report',
            'path' => url('storage/files/applications/' . $filename),
        ]);

        return $this->successResponse('Hisobot fayli muvaffaqiyatli yuklandi.');
    }
}
