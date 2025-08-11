<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function roles()
    {
        return $this->successResponse('', RoleResource::collection(Role::query()->get()));
    }

    public function getAllUsers()
    {
        $users = User::query()
            ->orderByDesc('created_at')
            ->paginate(\request()->query('pagination',20));
        return UserResource::collection($users);
    }

    public function getAll()
    {
        $users = User::query()
            ->withoutrole('admin')
            ->get()
            ->sortBy('profile.firstname');
        return UserResource::collection($users);
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'login' => 'required|unique:users,login',
            'password' => 'required|min:6',
            'firstname' => 'required',
            'lastname' => 'required',
            'surname' => 'required',
            'phone' => 'required|unique:user_profiles,phone',
            'birth' => 'required|date',
            'sex' => 'required|in:male,female,other',
            'organization' => 'sometimes',
            'bio' => 'sometimes',
        ]);

        try {
            $user = User::create([
                'login' => $request->login,
                'password' => $request->password,
                'is_active' => true,
            ]);

            $user->profile()->create([
                'user_id' => $user->id,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'surname' => $request->surname,
                'phone' => $request->phone,
                'birth' => $request->birth,
                'sex' => $request->sex,
                'organization' => $request->organization,
                'bio' => $request->bio,
            ]);

            $user->assignRole(Role::query()->find($request->role_id));

            return $this->successResponse('User created successfully', new UserResource($user));
        }catch (Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }
}
