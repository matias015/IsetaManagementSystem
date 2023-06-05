<header>
    <nav class="nav">
        <i class="uil uil-bars navOpenBtn"></i>
        <a href="#" class="logo">ISETA</a>
        <ul class="nav-links">
          
          <i class="uil uil-times navCloseBtn"></i>

          <li>
            <a href="{{route('alumno.info')}}"><i class="uil uil-estate"></i>Inicio</a>
          </li>

          <li><a href="{{route('alumno.info')}}">
            <i class="uil uil-user"></i>
            Perfil</a></li>
          <li><a href="{{route('alumno.cursadas')}}">
            <i class="uil uil-books"></i>
            Cursadas</a></li>
          <li><a href="{{route('alumno.examenes')}}">
            <i class="uil uil-folder"></i>
            Examenes</a></li>
          <li><a href="{{route('alumno.inscripciones')}}">
            <i class="uil uil-file-edit-alt"></i>
            Inscribir</a></li>
        </ul>
        @auth('web')
        <a href="{{route('alumno.logout')}}">
          <button>Cerrar sesion</button>
        </a>  
        @endauth
        
        
    </nav>
</header>