安装 jwt
https://laravel-china.org/articles/10885/full-use-of-jwt#c932c8



   
1. 在配置文件中添加哦

    ```
    “require”: {
           ...
           “tymon/jwt-auth”: “1.0.0-rc.3”
       }
    ```
       

2. composer update

    ```
    composer update
    #生成 密钥
    php artisan jwt:secret
    


3. 生成文件

    ```
    php artisan vendor:publish — provider=Tymon\JWTAuth\Providers\LaravelServiceProvider
    ```
   
4. 修改配置文件 将jwt 服务添加到 app.php 中

    ```
    provider
    
    Tymon\JWTAuth\Providers\LaravelServiceProvider::class,  
    
    aliases
    ‘JWTAuth’ => Tymon\JWTAuth\Facades\JWTAuth::class,
    ‘JWTFactory’ => Tymon\JWTAuth\Facades\JWTFactory::class,
    
    
    Kernel.php then add in $routeMiddleware
    
    ‘jwt.auth’ => \Tymon\JWTAuth\Http\Middleware\Authenticate::class,
    ‘jwt.refresh’ => \Tymon\JWTAuth\Http\Middleware\RefreshToken::class,
    ``` 
    
5. 修改 User.php

    ```
    use Tymon\JWTAuth\Contracts\JWTSubject;
    class User extends Authenticatable implements JWTSubject
    ```

