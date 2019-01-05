1. 添加响应头

    return response($content)
        ->header('Content-Type', $type)
        ->header('X-Header-One', 'Header Value')
        ->header('X-Header-Two', 'Header Value');
        
2. 添加 Cookie 到响应

    ->cookie($name, $value, $minutes, $path, $domain, $secure, $httpOnly)

    return response($content)
        ->header('Content-Type', $type)
        ->cookie('name', 'value', $minutes);
     
        
3. 重定向到命名路由


    redirect()->route('profile', ['id'=>1])
    
    
4. 重定向到控制器动作   
    
    
    return redirect()->action('HomeController@index');
    
    
5. 重定向到外部域名

    
    return redirect()->away('http://laravelacademy.org');
    
    
6. JSON响应


    return response()->json([
            'name' => 'Abigail', 
            'state' => 'CA'
    ]);

7.  JSONP 


    return response()
            ->json(['name' => 'Abigail', 'state' => 'CA'])
            ->withCallback($request->input('callback'));
            
    return response()
            ->jsonp($request->input('callback'), ['name' => 'Abigail', 'state' => 'CA']);
            
            
            
8. 文件下载

    
    return response()->download($pathToFile);
    return response()->download($pathToFile, $name, $headers);
    return response()->download($pathToFile)->deleteFileAfterSend(true);
    
    
9.流式下载
    
    
    return response()->streamDownload(function () {
        echo GitHub::api('repo')
                    ->contents()
                    ->readme('laravel', 'laravel')['contents'];
    }, 'laravel-readme.md');