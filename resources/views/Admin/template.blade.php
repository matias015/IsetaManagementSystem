<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="{{asset('css/Reset/reset.css')}}">
    <link rel="stylesheet" href="{{asset('css/Admin/Edit/edit-page.css')}}">
    <link rel="stylesheet" href="{{asset('css/Admin/main.css')}}">
    <link rel="stylesheet" href="{{asset('css/Admin/aside.css')}}">
    <link rel="stylesheet" href="{{asset('css/global.css')}}">
    <link rel="stylesheet" href="{{asset('css/form.css')}}">


    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
</head>

<body>

    <script src="{{asset('js/libs/ElementEv.js')}}"></script>
    <script src="{{asset('js/libs/ElementList.js')}}"></script>

    @include('Componentes.mensaje') 
    @include('Componentes.aside')
    @include('Componentes.confirmacion')

    <div class="admin-main w-80p p-5 just-end">
        @yield('content')
    </div>

    
    <script src="{{asset('js/ocultar-mensaje.js')}}"></script>
    <script src="{{asset('js/confirmacion.js')}}"></script>

</body>
</html>
