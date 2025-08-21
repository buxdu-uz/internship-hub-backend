<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoginResource;
use App\Http\Resources\UserResource;
use App\Models\SessionState;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use League\OAuth2\Client\Provider\GenericProvider;

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

    //oAuth2
    protected function getProvider(): GenericProvider
    {
        return new GenericProvider([
            'clientId'                => config('hemis.hemis.client_id'),
            'clientSecret'            => config('hemis.hemis.client_secret'),
            'redirectUri'             => config('hemis.hemis.redirect'),
            'urlAuthorize'            => config('hemis.hemis.authorize_url'),
            'urlAccessToken'          => config('hemis.hemis.token_url'),
            'urlResourceOwnerDetails' => config('hemis.hemis.resource_url'),
        ]);
    }

    public function redirectToProvider()
    {
        $provider = $this->getProvider();

        $authUrl = $provider->getAuthorizationUrl();

        Session::put('oauth2state', $provider->getState());

        return redirect($authUrl);
    }

    public function handleCallback(Request $request)
    {
        $provider = $this->getProvider();

//            dd($request->all(),!$request->has('code'), $request->get('state'),Session::get('oauth2state'));
        if (!$request->has('code') || $request->get('state') !== Session::get('oauth2state')) {
            Session::forget('oauth2state');
            return redirect('/')->withErrors('Invalid OAuth state');
        }

        try {
            $accessToken = $provider->getAccessToken('authorization_code', [
                'code' => $request->get('code')
            ]);

            $resourceOwner = $provider->getResourceOwner($accessToken);
            $user = $resourceOwner->toArray();
//            dd($user);
            Log::info("user: handlecallback",$user);
            $usrExist = User::where('login', $user['employee_id_number'])->first();

            if (!$usrExist){
                $usr = User::create([
                    'login' => $user['employee_id_number'],
                    'is_active' => 1,
                    'password' => bcrypt($user['employee_id_number'])
                ]);

                $usr->profile()
                    ->create([
                        'firstname' => $user['firstname'],
                        'lastname' => $user['surname'],
                        'surname' => $user['patronymic'],
                        'phone' => $user['phone'],
                        'birth' => $user['birth_date'],
                        'university_id' => $user['university_id'],
                        'avatar' => $user['picture'],
                        'passport_pinfl' => $user['passport_pin'],
                        'passport_number' => $user['passport_number'],
                    ]);

                $usr->assignRole('citizen');
            }


            Session::put('user',$user);
            Session::put('state',$request->get('state'));
            Session::put('code',$request->get('code'));

            SessionState::create([
                'state' => $request->get('state'),
                'employee_id_number' => $user['employee_id_number']
            ]);
            Log::info("path", array(config('hemis.front_url') . "/auth/hemis?state=" . $request->get('state')));
            return redirect()->away(config('hemis.front_url') . "/auth/hemis?state=" . $request->get('state'));
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function checkHemisAuth(Request $request)
    {
        Log::info("state", $request->all());
        $sessionState = SessionState::query()->latest()->first();
        $request->validate([
            'state' => 'required'
        ]);
//        dd($sessionState->state, $request->state);
        // Compare state and code from session
        if ($sessionState->state === $request->state) {
            $employee_id = $sessionState->employee_id_number;
//            Log::info("enmployeeid",$employee_id);
//            if ($employee_id == 3041911001 || $employee_id == 3042311060 || $employee_id == 3042011168 || $employee_id == 3041411007) {
            // Find the user in DB (optional if full object already in session)
            $authUser = User::query()
//                    ->whereIn('employee_id_number', [3041911001,3042311060,3042011168,3041411007])
                ->where('login', $employee_id)
                ->first();

//                Log::info("auth user",$authUser);

            if ($authUser) {
                // Log in the user
                Auth::login($authUser);

                // Optional: regenerate session for security
                Session::regenerate();

                return response()->json([
                    'status' => true,
                    'message' => 'Login successful',
                    'user' => new UserResource($authUser),
                    'token' => $authUser->createToken('API Token')->plainTextToken, // if using Sanctum
                ]);

            }
//            }else{
//                return response()->json([
//                    'message' => 'Sizning kirishingizga ruxsat mavjud emas!',
//                ], 403);
//            }
        }

        return response()->json([
            'message' => 'Unauthorized or invalid session state/code',
        ], 401);
    }
}
