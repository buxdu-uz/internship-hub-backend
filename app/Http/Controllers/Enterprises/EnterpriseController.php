<?php

namespace App\Http\Controllers\Enterprises;

use App\Http\Controllers\Controller;
use App\Http\Resources\EnterPriseResource;
use App\Models\Enterprise;
use App\Models\UserEnterprise;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EnterpriseController extends Controller
{
    public function getAll()
    {
        $enterprises = Enterprise::query()
            ->get();

        return $this->successResponse('',EnterPriseResource::collection($enterprises));
    }

    public function index()
    {
        $enterprises = Enterprise::query()
            ->paginate(\request()->query('pagination',20));

        return EnterPriseResource::collection($enterprises);
    }

    public function userEnterprises(Request $request)
    {
        $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
                Rule::unique('user_enterprises', 'user_id'),
            ],
            'enterprise_id' => 'required|exists:enterprises,id',
        ]);

        UserEnterprise::create([
            'user_id' => $request->user_id,
            'enterprise_id' => $request->enterprise_id,
        ]);

        return $this->successResponse(
            'User enterprise association created successfully');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'sometimes',
            'description' => 'nullable'
        ]);

        $enterprise = Enterprise::create($data);

        return $this->successResponse('',new EnterPriseResource($enterprise));
    }

    public function delete(Enterprise $enterprise)
    {
        $enterprise->delete();

        return $this->successResponse('Enterprise deleted successfully');
    }
}
