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

    $api->group(['prefix' => 'auth'], function ($api) {
        $api->get('captcha.jpg', 'User\IndexController@captcha');
        $api->post('login', 'AuthController@login')->name('login');
        $api->post('refresh', 'AuthController@refresh');
    });

    $api->group(['middleware' => ['api', 'jwt.auth']], function ($api) {
        $api->group(['prefix' => 'auth'], function ($api) {
            $api->post('logout', 'AuthController@logout');
            $api->post('me', 'AuthController@me');
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
            $api->put('update/{userid}', 'User\IndexController@update');
            //删除用户
            $api->delete('delete/{userid}', 'User\IndexController@delete');

            //测试redis 使用
            $api->post('pushInstructions.do', 'User\IndexController@setInstructions');
            $api->get('pullInstructions.do', 'User\IndexController@getInstructions');
        });

        //角色管理
        $api->group(['prefix' => 'role'], function ($api) {
            $api->get('', 'Role\IndexController@index');
            $api->post('', 'Role\IndexController@store');
            $api->get('/{roleId}', 'Role\IndexController@show');
            $api->put('/{roleId}', 'Role\IndexController@update');
            $api->delete('/{roleId}', 'Role\IndexController@delete');
        });


        //菜单管理
        $api->group(['prefix' => 'menu'], function ($api) {
            $api->get('', 'Menu\IndexController@index');
            $api->post('', 'Menu\IndexController@store');
            $api->get('/{menuId}', 'Menu\IndexController@show');
            $api->put('/{menuId}', 'Menu\IndexController@update');
            $api->delete('/{menuId}', 'Menu\IndexController@delete');
        });

        //接口管理

        $api->group(['prefix' => 'api'], function ($api) {
            $api->get('', 'Api\IndexController@index');
            $api->post('', 'Api\IndexController@store');
            $api->get('/{apiId}', 'Api\IndexController@show');
            $api->put('/{apiId}', 'Api\IndexController@update');
            $api->delete('/{apiId}', 'Api\IndexController@delete');
        });

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


});




