<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        //取消 Dingo\Api 接管 异常
//        app('api.exception')->register(function (\Exception $exception) {
//            $request = \Request::capture();
//            return app('App\Exceptions\Handler')->render($request, $exception);
//        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
