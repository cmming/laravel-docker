<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use Matrix\Exception;

class AuthController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api')->except(['login','register', 'forgetPassword', 'resetPassword', 'resetPasswordByToken','refresh']);
    }

    public function login(Request $request)
    {
        // 校验账号是由存在
        $validator = \Validator::make(request()->all(), [
            'username' => 'email|exists:users,email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        try {
            $token = app(Client::class)->post(url('/oauth/token'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('passport.clients.password.client_id'),
                    'client_secret' => config('passport.clients.password.client_secret'),
                    'username' => $request->get('username'),
                    'password' => $request->get('password'),
                    'scope' => '',
                ],
            ]);
            return $token;
        } catch (\Exception $e) {
            return $this->authError();
        }
    }

    public function me(Request $request)
    {
        $user = Auth::user();
        return response()->json($user);
    }

    public function refresh(Request $request){
        $validator = \Validator::make(request()->all(), [
            'refresh_token' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        $refresh_token = $request->get('refresh_token');
        try {
            $response = app(Client::class)->post(url('/oauth/token'), [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refresh_token,
                    'client_id' => config('passport.clients.password.client_id'),
                    'client_secret' => config('passport.clients.password.client_secret'),
                    'scope' => '',
                ],
            ]);
        }catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->authRefreshError();
        }

        return json_decode((string) $response->getBody(), true);
    }
}
