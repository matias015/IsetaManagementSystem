<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Registro</h1>
    <form method="POST" action="{{route('alumno.registro.post')}}">
        @csrf
        <input name="correo">
        <input name="password">
        <input type="submit" value="login">
    </form>

    @include('Comp.mensajes')

</body>
</html> 