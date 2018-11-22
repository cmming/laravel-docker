<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>重置密码</title>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
{{--<h1>{{$name}}</h1>--}}
<br><br><br>
<div class="container">
    <div class="row">
        {{--{{dd($datas)}}--}}
        <div class="col-xs-6 col-xs-offset-3">
            @if($datas['isok'])
                <form class="form-signin form-horizontal" method="POST" action="{{url('/api/restPwd')}}">
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{$datas['id']}}">
                    <input type="hidden" name="activationcode" value="{{$datas['activationcode']}}">
                    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="输入密码"
                    required>
                    <label class="sr-only">重复密码</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="重复输入密码"
                           required>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">确认修改</button>
                </form>
            @else
                <div class="alert alert-danger">链接过期，请重新发送请求！</div>
            @endif
        </div>
    </div>

</div>


</body>
</html>