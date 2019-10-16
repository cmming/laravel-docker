<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



$api = app('Dingo\Api\Routing\Router');
$api->version('v1', [
    'namespace' => 'App\Http\Controllers',
    'middleware'=>['lang']
], function ($api) {
    $api->post('auth/login', 'AuthController@login');
    $api->post('auth/refresh', 'AuthController@refresh');
    $api->group(['middleware' => ['refresh']], function($api){
//    $api->group(['middleware' => ['auth:api','refresh']], function($api){
        $api->get('auth/me', 'AuthController@me');
    });

    $api->group(['middleware' => ['auth:api']], function($api){
        \Laravel\Passport\Passport::$ignoreCsrfToken = true;
        $api->get('/user', function (Request $request) {
            return $request->user();
        });
    });
    $api->group(['middleware' => ['client']], function ($api) {
        $api->get('/test12', function (Request $request) {
            return '欢迎访问 Laravel 学院!';
        });
    });
});