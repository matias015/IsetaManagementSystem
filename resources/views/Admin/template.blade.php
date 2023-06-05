<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/Admin/main.css')}}">
    <link rel="stylesheet" href="{{asset('css/Admin/aside.css')}}">
</head>
<body style="background-color:#d5e1ff;">
    <div class="admin-main">
        @include('Comp.aside')
        @yield('content')
        @include('Comp.mensajes')
    </div>
    
</body>
</html>