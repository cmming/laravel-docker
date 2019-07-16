<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use App\Models\Log;
use Tymon\JWTAuth\Exceptions\JWTException;


class OperationLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $input = $request->all(); //操作的内容
        $log = new Log(); # 提前创建表、model
        try{
//            dd(JWTAuth::parseToken());
            $user_id = JWTAuth::parseToken()&&JWTAuth::parseToken()->authenticate()->toArray()['id'];
        }catch (JWTException $e){
//            echo $e->getMessage();
            $user_id = -1;
        }
        $log->user_id = $user_id;
        $log->url = $request->path();
        $log->method = $request->method();
        $log->ip = $request->ip();
        $log->operation = \Request::route()&&\Request::route()->action['description'] ? \Request::route()->action['description'] : '';
//        dd($api_id = \Request::route()->action['description']);
        $log->params = json_encode($input, JSON_UNESCAPED_UNICODE);
        $log->response = json_encode($response, JSON_UNESCAPED_UNICODE);
        $log->save();   # 记录日志

        return $response;
    }
}
