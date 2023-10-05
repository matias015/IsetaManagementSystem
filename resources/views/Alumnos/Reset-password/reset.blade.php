<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link rel="stylesheet" href="{{asset('css/estilos.css')}}">
    <link rel="stylesheet" href="{{asset('css/global.css')}}">
</head>

    <body class="p-2" id="logeo">
        @include('Componentes.mensaje')
    <div class="login">
        <form action="{{route('reset.password.mail')}}" method="get">
            <div class="logo">ISETA</div>
            <div class="titulo-login">
                <h1>Verificar correo</h1>
                <p>Ingresa el código de verificación enviado a su correo</p>
            </div>
            <div class="contraseña-token">
                Email <input name="email" required/>
            </div>
            <div class="crear input-box button"><input type="submit" value="Enviar mail"></div>
        </form>


    </div>
    <script src="{{asset('js/ocultar-mensaje.js')}}"></script>

    </body>
</html>