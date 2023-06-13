<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link rel="stylesheet" href="{{asset('css/estilos.css')}}">
</head>

    <body id="logeo">
        
    <div class="login">
        <form action="{{route('reset.password.post')}}" method="post">
            @csrf
            <div class="logo">ISETA</div>
            <div class="titulo-login">
                <h1>Verificar correo</h1>
                <p>Ingresa el código de verificación enviado a su correo</p>
            </div>
            <div class="contraseña-token">
                Token <input name="token" required/>
            </div>
            <div class="contraseña-token">
                Contraseña <input name="password" required/>
            </div>
            <div class="crear input-box button"><input type="submit" value="Restablecer"></div>
        </form>


    </div>

    </body>
</html>