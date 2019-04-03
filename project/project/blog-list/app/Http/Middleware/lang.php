<?php

namespace App\Http\Middleware;

use Closure;
//use Symfony\Contracts\Translation\TranslatorInterface;
//use Symfony\Contracts\Translation\TranslatorTrait;

class lang
{
//    public function getTranslator()
//    {
//        return new class() implements TranslatorInterface {
//            use TranslatorTrait;
//        };
//    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        if ($request->session()->has('lang')) {
//            $lang=\Session::get('lang');
//            if(\App::getLocale() != $lang) {
//                \App::setLocale($lang);
//            }
//        }else{
            //判断系统语言
            if(strrpos(strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']), 'zh-cn') !== false) {
//                  $this->getTranslator()->setLocale('en');
                if(\App::getLocale() != 'zh_CN'){
                    \App::setLocale('zh_CN');
                }
//                \App::setLocale('zh_CN');
            }
            else
            {
                if(\App::getLocale() != 'en') {
                    \App::setLocale('en');
                }
            }
//        $this->getTranslator()->setLocale('en');
//        \Lang::setLocale('zh_CN');
//        \Config::set('app.locale', 'vi');
        \App::setLocale('vi');
//            echo(\App::getLocale());exit();
//        }

        return $next($request);
    }
}
