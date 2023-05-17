<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="{{route('token.ingreso.post')}}">
        @csrf
        token
        <input name="token">
        <input type="submit" value="enviar">
    </form>
</body>
</html>