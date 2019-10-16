<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


//    public function login(Request $request)
//    {
//        $request->validate([
//            'email' => 'required|string',
//            'password' => 'required|string',
//        ]);
//
//        $http = new Client();
//        // 发送相关字段到后端应用获取授权令牌
//        $response = $http->post(url('/oauth/token'), [
//            'form_params' => [
//                'grant_type' => 'password',
//                'client_id' => config('services.blog.appid'),
//                'client_secret' => config('services.blog.secret'),
//                'username' => $request->input('email'),  // 这里传递的是邮箱
//                'password' => $request->input('password'), // 传递密码信息
//                'scope' => '*'
//            ],
//        ]);
//
//        return response($response->getBody());
//    }

//    public function login(Request $request)
//    {
//        // 校验账号是由存在
//        $validator = \Validator::make(request()->all(), [
//            'username' => 'email|exists:users,email',
//            'password' => 'required',
//        ]);
//        if ($validator->fails()) {
//            return $this->errorBadRequest($validator);
//        }
//        try {
//            $token = app(Client::class)->post(url('/oauth/token'), [
//                'form_params' => [
//                    'grant_type' => 'password',
//                    'client_id' => config('passport.clients.password.client_id'),
//                    'client_secret' => config('passport.clients.password.client_secret'),
//                    'username' => $request->get('username'),
//                    'password' => $request->get('password'),
//                    'scope' => '',
//                ],
//            ]);
//            return $token;
//        } catch (\Exception $e) {
//            return $this->authError();
//        }
//    }
}
