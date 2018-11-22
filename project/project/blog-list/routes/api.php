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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

$api = app('Dingo\Api\Routing\Router');

//,'verified' 邮箱验证中间件 后期制作
$api->version('v1', [
    'namespace' => 'App\Http\Controllers',
], function ($api) {
    $api->group(['middleware' => ['api'], 'prefix' => 'auth',], function ($api) {
        $api->post('login', 'AuthController@login')->name('login');
        $api->post('logout', 'AuthController@logout');
        $api->post('refresh', 'AuthController@refresh');
        $api->post('me', 'AuthController@me');
    });
    $api->group(['prefix' => 'user'], function ($api) {
        $api->post('register', 'User\RegisterController@register')->name('register');
    });
    //邮箱服务
    $api->group(['prefix' => 'mail'], function ($api) {
        //发送 注册 邮件 验证码
        $api->get('sendMailToRegister', 'Tool\MailController@sendMailToRegister');
        //激活账号
        $api->post('activeCount', 'Tool\MailController@activeCount');
        //发送邮件重置密码
        $api->post('sendMailToResetPwd', 'Tool\MailController@sendMailToResetPwd');
        //重置密码
        $api->post('ResetPwd', 'Tool\MailController@ResetPwd');
    });

    //管理用户
    $api->group(['prefix' => 'user'], function ($api) {
        //管理员列表
        $api->get('list', 'User\IndexController@index');
        //管理员信息
        $api->get('info/{userid}', 'User\IndexController@show');
        //添加用户
        $api->post('save', 'User\IndexController@store');
        //重置密码
        $api->put('password', 'User\IndexController@ResetPwd');
        //修改用户信息
        $api->put('update', 'User\IndexController@update');
        //删除用户
        $api->delete('delete', 'User\IndexController@delete');

        //测试redis 使用
        $api->post('pushInstructions.do', 'User\IndexController@setInstructions');
        $api->get('pullInstructions.do', 'User\IndexController@getInstructions');
    });
});




