<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoginResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['login' => $request->login, 'password' => $request->password])) {
            $user = Auth::user();

            $token = $user->createToken('token-name')->plainTextToken;

            return $this->successResponse($token,new LoginResource($user));
        }

        return $this->errorResponse('Login or password error', 401);
    }

    public function register(Request $request)
    {
        // 1. Validation
        $validator = Validator::make($request->all(), [
            'firstname'     => 'required|string',
            'lastname'      => 'required|string',
            'surname'       => 'required|string',
            'login'         => 'required|string|unique:users,login',
            'password'      => 'required|min:8',
            'sex'           => 'required|in:male,female',
            'phone'         => 'required|unique:users,phone',
            'birth'         => 'required|date',
            'organization'  => 'required|string',
            'bio'           => 'nullable|string',
        ], [
            'firstname.required'    => 'Ism maydoni to`ldirilishi shart.',
            'lastname.required'     => 'Familiya maydoni to`ldirilishi shart.',
            'surname.required'      => 'Otasining ismi maydoni to`ldirilishi shart.',
            'login.required'        => 'Login maydoni to`ldirilishi shart.',
            'login.unique'          => 'Bunday login avval ro`yxatdan o`tgan.',
            'password.required'     => 'Parol maydoni to`ldirilishi shart.',
            'phone.required'        => 'Telefon nomer maydoni to`ldirilishi shart.',
            'phone.unique'          => 'Bunday telefon raqami avval ro`yxatdan o`tgan.',
            'sex.in'                => 'Jins erkak yoki ayol bo`lishi kerak.',
            'birth.required'        => 'Tug`ilgan kuni maydoni to`ldirilishi shart.',
            'birth.date'            => 'Tug`ilgan kuni maydoni sana formatida bo‘lishi kerak.',
            'organization.required' => 'Tashkilot maydoni to`ldirilishi shart.',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors());
        }

        try {
            // 2. User yaratish
            $user = User::create([
                'login'         => $request->login,
                'password'      => $request->password,
            ]);

            $user->profile()->create([
                'firstname'     => $request->firstname,
                'lastname'      => $request->lastname,
                'surname'       => $request->surname,
                'sex'           => $request->sex,
                'phone'         => $request->phone,
                'birth'         => $request->birth,
                'organization'  => $request->organization,
                'bio'           => $request->bio,
            ]);

            // 3. Muvaffaqiyatli javob
            return $this->successResponse('User registered successfully', new UserResource($user));

        } catch (Exception $exception) {
            return $this->errorResponse($exception->getMessage());
        }
    }
}
