<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    
    <link rel="icon" type="image/png" href="img/icono-iseta.png">
        
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    
    <link rel="stylesheet" href="{{asset('css/Reset/reset.css')}}">
    
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link rel="stylesheet" href="{{asset('css/estilos.css')}}">

    <link rel="stylesheet" href="{{asset('css/header.css')}}">
    <link rel="stylesheet" href="{{asset('css/footer.css')}}">
    
    @yield('estilos')
    <link rel="stylesheet" href="{{asset('css/global.css')}}">
</head>



<body>

    <div class="m-2 p-2 rounded w-100">
        <div class="bg-gray-300 p-2 rounded">
            <p>Bienvenido <span class="font-600">{{$textFormatService->utf8UpperCamelCase($profesor->nombre)}}</span></p>
            <a class="red-600" href="{{route('profesor.logout')}}">Cerrar sesion</a>
        </div>
        
    
    
    <br><br>

    <h2>Proximas mesas</h2>
    <table>
        <tr>
            <td>Asignatura</td>
            <td>Fecha</td>
            <td>Rol</td>
            <td>Detalles</td>
        </tr>
    
    @foreach ($mesas as $mesa)
        <tr>
            <td>{{$mesa->materia->nombre}}</td>
            <td>{{$mesa->fecha}}</td>
            <td>
                @if ($mesa->prof_presidente == $profesor->id)
                    Presidente
                @elseif ($mesa->prof_vocal_1 == $profesor->id)
                    Vocal 1
                @elseif ($mesa->prof_vocal_2 == $profesor->id)
                    Vocal 2
                @endif
            </td>
            <td>
                <span class="blue-600">Acta</span>
                {{-- <a href="{{route('admin.mesas.edit',['mesa'=>$mesa->id])}}">Detalles</a> --}}
            </td>
        </tr>
    @endforeach
</table>
</div>
</body>
</html>