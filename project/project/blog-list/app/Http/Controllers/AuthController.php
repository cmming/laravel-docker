<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['jwt.auth'], ['except' => ['login','captcha.jpg']]);
//        $this->middleware(['auth:api'], ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {


//        $validator = \Validator::make($request->all(), [
//            'email' => 'required|email',
//            'password' => 'required',
//            'ckey' => 'required',
//            'captcha' => 'required|captcha_api:' . $request->input('ckey')
//        ],[
//            'captcha.required' => '验证码不能为空',
//            'captcha.captcha_api' => '请输入正确的验证码',
//        ]);

        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            // 错误批量处理
            return $this->errorBadRequest($validator);
        }

        $credentials = request(['name', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
//        auth()->logout();
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }


}