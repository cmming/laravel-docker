<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}
