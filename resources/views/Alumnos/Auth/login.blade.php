<!DOCTYPE html>
<html lang="es">
    <head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ISETA inscripciones</title>
        <link rel="icon" type="image/png" href="img/icono-iseta.png">
        <link rel="stylesheet" href="{{asset('css/estilos.css')}}">
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
        <script src="nav.js" defer></script>
        <link rel="stylesheet" href="{{asset('css/main.css')}}">
    </head>


<body id="logeo">
    
    <section class="login">
        <form method="post" action="{{route('alumno.login.post')}}">
            @csrf

            <div class="logo">ISETA</div>
            
            <div class="titulo-login">
                <h1>Inicio de sesión</h1>
                <p>¡Bienvenido! Por favor ingrese sus datos</p>
            </div>
            <div class="usuario input-box">
                <input value="matiasjf015@gmail.com" type="email" name="email" required placeholder="Nombre de usuario">
                <div class="underline"></div>
            </div>
            <div class="contraseña input-box">
                <input value="123" type="password" name="password"  required placeholder="Contraseña">
                <div class="underline"></div>
            </div>
            <div class="entrar input-box button"><input type="submit" value="Entrar"></div>
            <div class="etiquetas"><a href="{{route('alumno.registro')}}">¡Registrate!</a></div>
            <div class="etiquetas"><a href="{{route('reset.password')}}">¿Ha olvidado su contraseña?</a></div>
            
        </form>
        @include('Comp.mensajes')
    </section>
</body>
</html>


