<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Models\User;
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
            ->paginate(\request()->query('pagination',20));
        return UserResource::collection($users);
    }
}
