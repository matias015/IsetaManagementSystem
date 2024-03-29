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
        <link rel="stylesheet" href="{{asset('css/global.css')}}">
    </head>
<body class="p-2" id="logeo"> 
    @include('Componentes.mensaje')
    <section class="login">
        <div class="who">
            <a class="tag-alumno" href="{{route('alumno.registro')}}">Alumno</a>
            <a class="tag-profesor act2" href="{{route('profesor.register')}}">Profesor</a>
        </div>
        <form action="{{route('profesor.register.post')}}" method="post">
            @csrf   
            <div class="logo">ISETA</div>
            <div class="titulo-login">
                <h1>Registrate</h1>
                <p>¡Bienvenido! Por favor ingrese sus datos</p>
            </div>
            <div class="usuario input-box underline">
                <input value="" type="email" name="email" required placeholder="Correo electronico">
                <div class="underline"></div>
            </div>
            <div class="dni input-box">
                <input value="" type="text" name="dni" required placeholder="DNI">
                <div class="underline"></div>
            </div>
            <div class="contraseña input-box">
                <input value="" type="password" name="password" required placeholder="Contraseña">
                <div class="underline"></div>
            </div>
            <div class="crear input-box button"><input type="submit" value="Crear"></div>
            <div class="etiquetas"><p>¿Ya estas registrado?<a href="{{route('profesor.login')}}">¡Inicia sesion!</a></p></div>
            
        </form>
    </section>
</body>
</html>
