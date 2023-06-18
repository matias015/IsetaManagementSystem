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
        <div class="perfil-logout" >
          <div class="perfil-logout-btn">
            <div class="perfil-imagen">
              
            </div>
            <span>
              Matias
              <i class="ti ti-chevron-down"></i>
            </span>
          </div>
          <ul class="perfil-lista">
            <li class="perfil-lista-item"><a href="perfil.html"><i class="ti ti-user"></i>Editar perfil</a>
              </li>
            <li class="perfil-lista-item"><a><i class="ti ti-settings"></i>Ajustes</li></a></li>
            <li class="perfil-lista-item"><a href=""><i class="ti ti-logout"></i>Cerrar sesion</a></li>
            <hr>
            <li class="perfil-lista-item"><a><i class="ti ti-sun"></i>Modo</a></li>
          </ul>
          
        </div>
        @endauth
        
        
    </nav>
</header>