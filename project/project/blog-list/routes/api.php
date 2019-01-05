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
        $api->get('captcha.jpg', ['uses' => 'User\IndexController@captcha']);
        $api->post('login', ['uses' => 'AuthController@login'])->name('login');
        $api->post('refresh', ['uses' => 'AuthController@refresh']);
    });

    $api->group(['middleware' => ['api', 'jwt.auth','operationLog']], function ($api) {
        $api->group(['prefix' => 'auth'], function ($api) {
            $api->post('logout', ['uses' => 'AuthController@logout']);
            $api->post('me', ['uses' => 'AuthController@me']);
        });

        //管理用户
        $api->group(['prefix' => 'user'], function ($api) {
            //管理员列表
            $api->get('list', ['uses' => 'User\IndexController@index']);
            //管理员信息
            $api->get('info/{userid}', ['uses' => 'User\IndexController@show']);
            //添加用户
            $api->post('save', ['uses' => 'User\IndexController@store']);
            //重置密码
            $api->put('password', ['uses' => 'User\IndexController@ResetPwd']);
            //修改用户信息
            $api->put('update/{userid}', ['uses' => 'User\IndexController@update']);
            //删除用户
            $api->delete('delete/{userid}', ['uses' => 'User\IndexController@delete']);

            //测试redis 使用
            $api->post('pushInstructions.do', ['uses' => 'User\IndexController@setInstructions']);
            $api->get('pullInstructions.do', ['uses' => 'User\IndexController@getInstructions']);
        });

        //角色管理
        $api->group(['prefix' => 'role'], function ($api) {
            $api->get('', ['uses' => 'Role\IndexController@index']);
            $api->post('', ['uses' => 'Role\IndexController@store']);
            $api->get('/{roleId}', ['uses' => 'Role\IndexController@show']);
            $api->put('/{roleId}', ['uses' => 'Role\IndexController@update']);
            $api->delete('/{roleId}', ['uses' => 'Role\IndexController@delete']);
        });


        //菜单管理
        $api->group(['prefix' => 'menu'], function ($api) {
            $api->get('', ['uses' => 'Menu\IndexController@index']);
            $api->post('', ['uses' => 'Menu\IndexController@store']);
            $api->get('/{menuId}', ['uses' => 'Menu\IndexController@show']);
            $api->put('/{menuId}', ['uses' => 'Menu\IndexController@update']);
            $api->delete('/{menuId}', ['uses' => 'Menu\IndexController@delete']);
        });

        //接口管理

        $api->group(['prefix' => 'api'], function ($api) {
            $api->get('', ['uses' => 'Api\IndexController@index']);
            $api->post('', ['uses' => 'Api\IndexController@store']);
            $api->get('/{apiId}', ['uses' => 'Api\IndexController@show']);
            $api->put('/{apiId}', ['uses' => 'Api\IndexController@update']);
            $api->delete('/{apiId}', ['uses' => 'Api\IndexController@delete']);
        });

        //日志管理
        $api->group(['prefix' => 'log'], function ($api) {
            $api->get('', ['uses' => 'Log\IndexController@index']);
        });

        //文件管理
        $api->group(['prefix' => 'file'], function ($api) {
            $api->get('/curentFile', ['uses' => 'File\IndexController@index']);
        });

    });
    $api->group(['prefix' => 'user'], function ($api) {
        $api->post('register', ['uses' => 'User\RegisterController@register'])->name('register');
    });
    //邮箱服务
    $api->group(['prefix' => 'mail'], function ($api) {
        //发送 注册 邮件 验证码
        $api->get('sendMailToRegister', ['uses' => 'Tool\MailController@sendMailToRegister']);
        //激活账号
        $api->post('activeCount', ['uses' => 'Tool\MailController@activeCount']);
        //发送邮件重置密码
        $api->post('sendMailToResetPwd', ['uses' => 'Tool\MailController@sendMailToResetPwd']);
        //重置密码
        $api->post('ResetPwd', [
            'uses' => 'Tool\MailController@ResetPwd',
            'des' => '保存前端路由',
        ]);
    });


});




