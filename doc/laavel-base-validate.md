1. 自定义验证规则
   
      
     # https://laravelacademy.org/post/9547.html
    php artisan make:rule Uppercase
    
    
    
2. 使用


    $this->validate($request, [
        'title' => 'required|unique:posts|max:255',
        'body' => 'required',
        'publish_at' => 'nullable|date',
    ]);
    
3. 处理错误信息

    
    foreach ($errors->get('email') as $message) {
        //
    }
    
    $validator = \Validator::make(['id' => $id], [
                'id' => 'required|numeric|exists:vesystem_web_post,id'
            ]);
    
            if ($validator->fails()) {
                return $this->errorBadRequest($validator);
            }