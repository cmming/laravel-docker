<?php
/**
 * Created by PhpStorm.
 * User: chenming
 * Date: 2019/8/6
 * Time: 23:23
 */

namespace App\Http\Middleware;


use Closure;
use Dingo\Api\Http\Response;

class ProcessJsonResponse
{

    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if (
            false
//            env("APP_DEBUG")
//            &&
//            $request->ajax()
//            &&
//            $response instanceof Response &&
//            app()->bound('debugbar') &&
//            app('debugbar')->isEnabled()
        ) {
            $debugbar_data=app('debugbar')->getData();
            $queries_data = $this->sqlFilter($debugbar_data);
            $total_duration_time=array_get($debugbar_data, 'time.duration_str');
            $response->setContent(json_decode($response->morph()->getContent(), true) + [
                    '_debugbar' => [
                        'total_queries' => count($queries_data),
                        'total_duration_time'=>$total_duration_time,
                        'queries' => $queries_data,
                    ]
                ]);
        }

        return $response;
    }

    protected function sqlFilter($debugbar_data) {
        $result = array_get($debugbar_data, 'queries.statements');

        return array_map(function ($item) {
            return [
                'sql' => array_get($item, 'sql'),
                'duration' => array_get($item, 'duration_str'),
            ];
        }, $result);
    }
}