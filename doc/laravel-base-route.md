1. route 

    RouteServiceProvider   
    
    Route::prefix('api')           //定义前缀
                 ->middleware('api')    //定义加载的中间件 在 app/http/kernel 中的 $middlewareGroups 的 api
                 ->namespace($this->namespace)      //定义 基本的命名空间
                 ->group(base_path('routes/api.php'));  //定义路由的文件
                 
                 
2. 路由重定向
     将 here 重定向到 /there 同时 给一个状态码为301            
     Route::redirect('/here', '/there', 301);
     
3. 参数
    # 可选参数
    Route::get('user/{name?}', function ($name = null) {
        return $name;
    });
    # 正则约束
    Route::get('user/{name}', function ($name) {
        // $name 必须是字母且不能为空
    })->where('name', '[A-Za-z]+');
    #全局约束  需要在 RouteServiceProvider 类的 boot 方法中定义这种约束模式：
    public function boot()
    {
        Route::pattern('id', '[0-9]+');
        //路由参数为 id 的都必须是数字才能进入
        parent::boot();
    }
    #命名路由
    name
    #路由分组
    group
    #中间件
    Route::middleware(['first', 'second'])->group
    
    #路由前缀 
    ::prefix('admin')
    ::name('admin.')
    
    #兜底路由
    定义一个当所有其他路由都未能匹配请求 URL 时所执行的路由。通常，未处理请求会通过 Laravel 的异常处理器自动渲染一个「404」页面，不过，
    如果你在 routes/web.php 文件中定义了 fallback 路由的话，所有 web 中间件组中的路由都会应用此路由作为兜底
    
    #访问当前路由
    // 获取当前路由实例
    $route = Route::current(); 
    // 获取当前路由名称
    $name = Route::currentRouteName();
    // 获取当前路由action属性
    $action = Route::currentRouteAction();