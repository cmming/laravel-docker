<?php

namespace App\Http\Middleware;

use Closure;

//use Symfony\Contracts\Translation\TranslatorInterface;
//use Symfony\Contracts\Translation\TranslatorTrait;

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
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            \Config::set('app.locale', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        } else {
            \Config::set('app.locale', 'zh_CN');
        }
        return $next($request);
    }
}
