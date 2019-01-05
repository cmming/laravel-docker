
1.创建路由


    php artisan make:controller UserController 


2.资源控制器


    php artisan make:controller PostController --resource
    #资源路由器
    Route::resource('posts', 'PostController');
    #API 资源路由
    Route::apiResource('post', 'PostController');