<ul>
    <li><a href="{{route('alumno.info')}}">info</a></li>
      
    <hr>
    @auth
        <li><a href="{{route('alumno.logout')}}">logout</a></li>
        <li>Bienvenido {{ auth()->user()->nombre }}</li>    
    @endauth
    @guest
    <li><a href="{{route('alumno.login')}}">login-alumno</a></li>
    <li><a href="{{route('alumno.registro')}}">registro-alumno</a></li>  
    @endguest
    <hr>
</ul>