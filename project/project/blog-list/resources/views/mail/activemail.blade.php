<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<body>
尊敬的 {{ $name }} ：
<br>
{{ URL('api/activeMail?id='.$id.'&activationcode='.$activationcode) }}
<a href="{{ URL('/api/activeMail?id='.$id.'&activationcode='.$activationcode) }}" target="_blank">
    请点击此处激活XXX账号
</a>
</body>
</html>