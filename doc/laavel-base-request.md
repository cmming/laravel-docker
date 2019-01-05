

1. 所有参数

    $input = $request->all();

2. 查询指定参数

    $name = $request->query('name');

3. 取出上次请求数据


    $username = $request->old('username');
    <input type="text" name="username" value="{{ old('username') }}">
    
4. 从请求中取出Cookie
    
    $value = $request->cookie('name');
    $value = Cookie::get('name');
    
    
5. 文件上传
    
    $file = $request->file('photo');
    $file = $request->photo;
    
6. 获取请求 URL
    
    / 不包含查询字符串
    $url = $request->url();
    
    // 包含查询字符串
    $url_with_query = $request->fullUrl();