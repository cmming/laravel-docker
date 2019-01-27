<?php
/**
 * Created by PhpStorm.
 * User: chmi
 * Date: 2019/1/10
 * Time: 17:23
 */

namespace App\Http\Middleware;


use Closure;
use App\Jobs\ElasticSearchLog as JElasticSearchLog;
use App\Facades\ElasticSearchClient;

class ElasticSearchLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    /**
     * @param $request
     * @param $response
     * Written by Zhou Yubin(zhouyb@fengrongwang.com)
     */
    public function terminate($request, $response)
    {
        $documents = ElasticSearchClient::getDocuments();
        // 需要判断是否有日志
        if (count($documents) > 0) {
            dispatch(new JElasticSearchLog($documents));
        }
    }
}