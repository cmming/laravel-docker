<?php

namespace App\Http\Middleware;

use Closure;


class Lang
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
        //判断系统语言
        if (\Request::header('lang')&&\Request::header('lang')=='en') {
            \App::setLocale('en');
        } else {

            \App::setLocale('zh');
        }
        return $next($request);
    }
}
