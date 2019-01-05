<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use App\Models\Log;


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
        $log->user_id = JWTAuth::parseToken()->authenticate()->toArray()['id'];
        $log->url = $request->path();
        $log->method = $request->method();
        $log->ip = $request->ip();
        $log->params = json_encode($input, JSON_UNESCAPED_UNICODE);
        $log->response = json_encode($response, JSON_UNESCAPED_UNICODE);
        $log->save();   # 记录日志

        return $response;
    }
}