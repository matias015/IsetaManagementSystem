<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/Admin/login.css')}}">
</head>
<body>
    <div class="login-box">
 
        <form method="POST" action="{{route('admin.login.post')}}">
            @csrf
          <div class="user-box">
            <input type="text" name="username" required="">
            <label>Username</label>
          </div>
          <div class="user-box">
            <input name="password" name="" required="">
            <label>Password</label>
          </div>
          <input type="submit" value="Login">
        </form>
      </div>
      @include('Componentes.mensaje')
</body>
</html>