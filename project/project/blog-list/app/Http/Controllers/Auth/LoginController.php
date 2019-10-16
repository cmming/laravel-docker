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
    public function client()
    {
        $http = new Client();
        $response = $http->post('http://192.168.50.58:82/oauth/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => config('services.blog.appid'),  // your client id
                'client_secret' => config('services.blog.secret'),   // your client secret
                'scope' => '*'
            ],
        ]);

        return response($response->getBody());
    }
    public function oauth()
    {

        $query = http_build_query([
            'client_id' => config('services.blog.appid'),
            'redirect_uri' => config('services.blog.callback'),
            'response_type' => 'code',
            'scope' => 'all-user-info get-post-info',
        ]);

        return redirect('http://192.168.50.58:85/oauth/authorize?'.$query);
    }

    public function callback(Request $request)
    {
        $code = $request->get('code');
        if (!$code) {
            dd('授权失败');
        }
        $http = new \GuzzleHttp\Client();
//        docker 环境
        try {
            $response = $http->post('http://nginx:85/oauth/token', [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'client_id' => config('services.blog.appid'),  // your client id
                    'client_secret' => config('services.blog.secret'),   // your client secret
//                'redirect_uri' => 'www.baidu.com',
                    'redirect_uri' => config('services.blog.callback'),
                    'code' => $code,
                ],
            ]);
            \Log::info($response->getBody());
            return $response->getBody();
            return response($response->getBody());
        }catch (\Exception $e) {
            return response()->json(\App\Exceptions\ErrorMessage::getMessage(\App\Exceptions\ErrorMessage::AUTHORIZATION_CODE_ERROR), 400);
        }
    }
}
