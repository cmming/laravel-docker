    
1. 一个请求的生命周期

    public/index.php(自动加载各种插件) ------>bootstrap/app.php(创建容器， 绑定重要定义接口)
    --->(HTTP/Console 内核 HTTP 内核或 Console 内核; 分别用于处理 Web 请求和 Artisan 命令.)
    
    
    
    Illuminate\Foundation\Bootstrap\DetectEnvironment 环境配置（$app['env']）
    Illuminate\Foundation\Bootstrap\LoadConfiguration  基本配置（$app['config']）
    Illuminate\Foundation\Bootstrap\ConfigureLogging   日志文件（$app['log']）
    Illuminate\Foundation\Bootstrap\HandleExceptions   错误&异常处理
    Illuminate\Foundation\Bootstrap\RegisterFacades    清除已解析的Facade并重新启动，注册config文件中alias定义的所有Facade类到容器
    Illuminate\Foundation\Bootstrap\RegisterProviders  注册config中providers定义的所有Providers类到容器
    Illuminate\Foundation\Bootstrap\BootProviders      调用所有已注册Providers的boot方法
    
    web请求-->app/Http/Kernel.php (容器创建的时候会在Illuminate\Foundation\Console 中的有$bootstrappers常量定义了会默认加载的一系列的启动类, $bootstrappers 错误处理、日志、检测应用环境) 同时对外暴露 middleware（每个web 请求的时候要执行的）和middlewareGroups（路由的中间件）
    以及 $routeMiddleware（需要注册后才能）
    
    
    HTTP 内核的 handle 方法签名相当简单：获取一个 Request，返回一个 Response，可以把该内核想象作一个代表整个应用的大黑盒子，输入 HTTP 请求，返回 HTTP 响应。
    
    
2. 服务容器

3. 服务提供者

4. 门面（Facades）

5. 契约（Contracts）
    