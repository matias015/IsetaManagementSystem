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
    <link rel="stylesheet" href="{{asset('css/profesor.css')}}">
    
    @yield('estilos')
    <link rel="stylesheet" href="{{asset('css/global.css')}}">
</head>



<body>
    <div class="profesor">
        <div class="flex just-between p-header">
            <a href="/profesor/mesas" class="logo">ISETA</a>
            <!--
            <div class="flex just-center items-center p-logout">
                <span class="font-600 p-name">{{$profesor->nombre}}</span>
                <a class="red-600" href="{{route('profesor.logout')}}"><i class="ti ti-logout"></i>Cerrar sesion</a>
            </div>
            -->
            <div class="perfil-logout" >
                <div class="perfil-logout-btn"> 
                    <span>{{$profesor->nombre}}<i class="ti ti-chevron-down"></i></span>
                </div>
          
                <ul class="perfil-lista shadow-2xl">
                <!---
                    <li class="perfil-lista-item">
                        <a @class(['bold'=>request()->is('profesor/mesas')]) href="{{route('profesor.mesas')}}">
                        <i class="uil uil-user"></i> Perfil</a>
                    </li>--->
                    <li class="perfil-lista-item"><a href="{{route('profesor.logout')}}"><i class="ti ti-logout"></i>Cerrar sesion</a></li>
                </ul> 
            </div>    
        </div>

        <main>
            <section class="table">
                <div class="table__header">
                    <h1>Proximas mesas</h1>
                </div>
                <div class="table__body">
                    <table>
                        <thead>
                            <tr>
                                <th>Asignatura</th>
                                <th>Fecha</th>
                                <th>Rol</th>
                                <th>Detalles</th>
                            </tr>
                        </thead>
                        
                    @foreach ($mesas as $mesa)
                        <tr>
                            <td>{{$mesa->asignatura->nombre}}</td>
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
                                <a href="{{route('admin.mesas.acta',['mesa'=>$mesa->id])}}" target="__blank"><button class="btn-p-acta">Acta volante</button></a>
                            </td>
                        </tr>
                    @endforeach
                    </table>
                </div>
            </section>
        </main>

        
        
    </div>
    <script src="{{asset('js/nav-menu.js')}}"></script>
</body>
</html>
