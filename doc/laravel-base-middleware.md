
1.定义

```
php artisan make:middleware CheckToken  
```   
    

2. 请求之前/之后的中间件

    
    //前置
    <?php
    
    namespace App\Http\Middleware;
    
    use Closure;
    
    class BeforeMiddleware
    {
        public function handle($request, Closure $next)
        {
            // 执行动作
    
            return $next($request);
        }
    }
    
    //后置
    <?php
    
    namespace App\Http\Middleware;
    
    use Closure;
    
    class AfterMiddleware
    {
        public function handle($request, Closure $next)
        {
            $response = $next($request);
    
            // 执行动作
    
            return $response;
        }
    }
    
    
3.注册中间件

    将中间件类添加 app/Http/Kernel.php 的数组属性 $middleware 中即可：
    
    
4. 中间件参数

   
    额外的中间件参数会在 $next 参数之后传入中间件：
    <?php
    
    namespace App\Http\Middleware;
    
    use Closure;
    
    class CheckRole
    {
        /**
         * 处理输入请求
         *
         * @param \Illuminate\Http\Request $request
         * @param \Closure $next
         * @param string $role
         * @return mixed
         * translator http://laravelacademy.org
         */
        public function handle($request, Closure $next, $role)
        {
            if (! $request->user()->hasRole($role)) {
                // Redirect...
            }
    
            return $next($request);
        }
    
    }
    #调用
    Route::put('post/{id}', function ($id) {
        //
    })->middleware('CheckRole:editor');
    
    
    
5. 终端中间件


    中间件可能需要在 HTTP 响应发送到浏览器之后做一些工作，比如，Laravel 内置的 session 
    中间件会在响应发送到浏览器之后将 Session 数据写到存储器中，为了实现这个功能，需要定义
    一个终止中间件并添加 terminate 方法到这个中间件：
    
    <?php
    
    namespace Illuminate\Session\Middleware;
    
    use Closure;
    
    class StartSession
    {
        public function handle($request, Closure $next)
        {
            return $next($request);
        }
    
        public function terminate($request, $response)
        {
            // 存储session数据...
        }
    }