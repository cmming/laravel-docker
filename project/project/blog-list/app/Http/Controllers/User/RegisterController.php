<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\User;

class RegisterController extends Controller
{
    //
    public function register(Request $request)
    {
        $newUser = [
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('password'))
        ];

        $user = User::create($newUser);

        return response()->json(['message' => 'Successfully Register']);
    }


    public function reset(Request $request){
        $user = User::where('email','=',$request->input('email'))->first();
//        $user = User::find(7);
        $token = JWTAuth::fromUser($user);
//        var_dump($token);exit();
        $user->sendPasswordResetNotification($token);
    }
}
