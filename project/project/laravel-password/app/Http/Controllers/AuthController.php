<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Matrix\Exception;

class AuthController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api')->except(['login', 'register', 'forgetPassword', 'resetPassword', 'resetPasswordByToken', 'me']);
    }

    public function login(Request $request)
    {
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

//        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
//            $user = Auth::user();
//            $success['token'] = $user->createToken('MyApp')->accessToken;
//            $success['refresh_token'] = $user->withAccessToken('MyApp')->accessToken;
//            return response()->json(['success' => $success]);
//        } else {
//            return response()->json(['error' => 'Unauthorised'], 401);
//        }
    }

    public function me(Request $request)
    {
        $user = Auth::user();
        return response()->json(['success' => $user]);
    }
}
