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
    'middleware' => 'lang',
], function ($api) {

    $api->group(['prefix' => 'auth'], function ($api) {
        $api->get('captcha.jpg', ['uses' => 'User\IndexController@captcha', 'description' => "获取验证码"]);
        $api->post('login', ['uses' => 'AuthController@login', 'description' => "用户登陆"])->name('login');
        $api->post('refresh', ['uses' => 'AuthController@refresh', 'description' => "刷新token"]);
        $api->post('logout', ['uses' => 'AuthController@logout', 'description' => "退出登陆"]);
    });


    $api->group(['middleware' => ['api', 'jwt.auth', 'operationLog']], function ($api) {
        $api->group(['prefix' => 'auth'], function ($api) {
//            $api->post('logout', ['uses' => 'AuthController@logout', 'description' => "退出登陆"]);
            $api->post('me', ['uses' => 'AuthController@me', 'description' => "获取自己信息"]);
            $api->post('authorization/user/info', ['uses' => 'AuthController@info', 'description' => "用户信息"]);
        });

        //管理用户
        $api->group(['prefix' => 'user'], function ($api) {
            //管理员列表
            $api->get('', ['uses' => 'User\IndexController@index', 'description' => "获取管理员信息"]);
            //管理员信息
            $api->get('/{userid}', ['uses' => 'User\IndexController@show', 'description' => "获取管理员详情"]);
            //添加用户
            $api->post('', ['uses' => 'User\IndexController@store', 'description' => "添加管理员"]);
            //重置密码
            $api->put('password', ['uses' => 'User\IndexController@ResetPwd', 'description' => "修改管理员密码"]);
            //修改用户信息
            $api->put('/{userid}', ['uses' => 'User\IndexController@update', 'description' => "修改管理员信息"]);
            //删除用户
            $api->delete('/{userid}', ['uses' => 'User\IndexController@delete', 'description' => "删除管理员"]);

            //测试redis 使用
            $api->post('pushInstructions.do', ['uses' => 'User\IndexController@setInstructions', 'description' => "从redis设置数据"]);
            $api->get('pullInstructions.do', ['uses' => 'User\IndexController@getInstructions', 'description' => "从redis读取数据"]);

        });

        //角色管理
        $api->group(['prefix' => 'role'], function ($api) {
            $api->get('', ['uses' => 'Role\IndexController@index', 'description' => "获取角色列表"]);
            $api->post('', ['uses' => 'Role\IndexController@store', 'description' => "添加一个角色"]);
            $api->get('/{roleId}', ['uses' => 'Role\IndexController@show', 'description' => "获取一个角色详情"]);
            $api->put('/{roleId}', ['uses' => 'Role\IndexController@update', 'description' => "更新一个角色信息"]);
            $api->delete('/{roleId}', ['uses' => 'Role\IndexController@delete', 'description' => "删除一个角色"]);
            $api->get('/routers/{roleId}', ['uses' => 'Role\IndexController@routers', 'description' => "获取路由的router"]);
            $api->put('/routers/{roleId}', ['uses' => 'Role\IndexController@storeRouter', 'description' => "修改一个角色拥有的路由"]);
        });


        //菜单管理
        $api->group(['prefix' => 'menu'], function ($api) {
            $api->get('', ['uses' => 'Menu\IndexController@index', 'description' => "获取目录的列表"]);
            $api->post('', ['uses' => 'Menu\IndexController@store', 'description' => "保存一个目录"]);
            $api->get('/{menuId}', ['uses' => 'Menu\IndexController@show', 'description' => "获取一个目录的详情"]);
            $api->put('/{menuId}', ['uses' => 'Menu\IndexController@update', 'description' => "更新一个目录的详情"]);
            $api->delete('/{menuId}', ['uses' => 'Menu\IndexController@delete', 'description' => "删除一个目录"]);
        });

        //接口管理
        //router 管理
        $api->group(['prefix' => 'router'], function ($api) {
            //管理员列表
            $api->get('', ['uses' => 'Router\IndexController@index', 'description' => "获取Router信息"]);
            //管理员信息
            $api->get('/{id}', ['uses' => 'Router\IndexController@show', 'description' => "获取Router详情"]);
            //添加用户
            $api->post('', ['uses' => 'Router\IndexController@store', 'description' => "添加Router"]);
            //修改用户信息
            $api->put('/{id}', ['uses' => 'Router\IndexController@update', 'description' => "修改Router信息"]);
            //删除用户
            $api->delete('', ['uses' => 'Router\IndexController@destroy', 'description' => "删除管理员"]);
        });

        $api->group(['prefix' => 'api'], function ($api) {
            $api->get('', ['uses' => 'Api\IndexController@index', 'description' => "获取api列表"]);
            $api->post('', ['uses' => 'Api\IndexController@store', 'description' => "保存一个api"]);
            $api->get('/{apiId}', ['uses' => 'Api\IndexController@show', 'description' => "获取一个api详情"]);
            $api->put('/{apiId}', ['uses' => 'Api\IndexController@update', 'description' => "更新一个api"]);
            $api->delete('/{apiId}', ['uses' => 'Api\IndexController@delete', 'description' => "删除一个api"]);
        });

        //日志管理
        $api->group(['prefix' => 'log'], function ($api) {
            $api->get('', ['uses' => 'Log\IndexController@index', 'description' => "获取日志列表"]);
        });

        //文件管理
        $api->group(['prefix' => 'file'], function ($api) {
            $api->get('/curentFile', ['uses' => 'File\IndexController@index', 'description' => "获取指定文件路径的结构"]);
            $api->post('/uploadCompanyImg', ['uses' => 'File\IndexController@uploadCompanyImg', 'description' => "上传图片"]);
        });


    });
    $api->group(['prefix' => 'user'], function ($api) {
        $api->post('register', ['uses' => 'User\RegisterController@register', 'description' => "用户注册"])->name('register');
    });
//邮箱服务
    $api->group(['prefix' => 'mail'], function ($api) {
        //发送 注册 邮件 验证码
        $api->get('sendMailToRegister', ['uses' => 'Tool\MailController@sendMailToRegister', 'description' => "注册时邮箱验证码"]);
        //激活账号
        $api->post('activeCount', ['uses' => 'Tool\MailController@activeCount', 'description' => "激活账号"]);
        //发送邮件重置密码
        $api->post('sendMailToResetPwd', ['uses' => 'Tool\MailController@sendMailToResetPwd', 'description' => "邮件重置密码"]);
        //重置密码
        $api->post('ResetPwd', [
            'uses' => 'Tool\MailController@ResetPwd',
            'des' => '重置密码',
        ]);
    });


});




