<header>
    <nav class="nav items-center">
        <i class="uil uil-bars navOpenBtn"></i>
        <a href="#" class="logo">ISETA</a>
        <ul class="nav-links">
          
          <i class="uil uil-times navCloseBtn"></i>

          <li><a @class(['bold'=>request()->is('alumno/info')]) href="{{route('alumno.info')}}">
            <i class="uil uil-user"></i>
            Perfil</a></li>
          <li><a @class(['bold'=>request()->is('alumno/cursadas')]) href="{{route('alumno.cursadas')}}">
            <i class="uil uil-books"></i>
            Cursadas</a></li>
          <li><a @class(['bold'=>request()->is('alumno/examenes')]) href="{{route('alumno.examenes')}}">
            <i class="uil uil-folder"></i>
            Examenes</a></li>
          <li><a @class(['bold'=>request()->is('alumno/inscripciones')]) href="{{route('alumno.inscripciones')}}">
            <i class="uil uil-file-edit-alt"></i>
            Inscribir</a></li>
            <li>
              <a @class([
                'bold' => request()->is('alumno/rematriculacion/carrera'),
                'bold' => request()->is('alumno/rematriculacion')
              ]) href="{{route('alumno.rematriculacion.carrera')}}"><i class="uil uil-estate"></i>Rematriculacion</a>
            </li>
        </ul>
        @auth('web')
        <div class="perfil-logout" >
          <div class="perfil-logout-btn" onclick="toggle()"> 
          {{-- <div class="white pointer" onclick="toggle()">--}}
            <!--<div class="perfil-imagen">
              
            </div> -->
            <span>
              {{auth()->user()->nombre}}
              <i class="ti ti-chevron-down"></i>
            </span>
            
          </div>
          
          <ul class="perfil-lista shadow-2xl">
            <li class="perfil-lista-item"><a><i class="ti ti-settings"></i>Ajustes</li></a></li>
            <li class="perfil-lista-item"><a href="/alumno/logout"><i class="ti ti-logout"></i>Cerrar sesion</a></li>
            <hr>
            <li class="perfil-lista-item"><a><i class="ti ti-sun"></i>Modo</a></li>
          </ul>
         
        </div> 
        @endauth
    </nav>
    <script>
    let perfilDropdownList = document.querySelector(".perfil-lista")
let btn = document.querySelector(".perfil-logout-btn")

const toggle = () => perfilDropdownList.classList.toggle("active")

window.addEventListener('click', function(e) {

    if (!btn.contains(e.target))perfilDropdownList.classList.remove('active')
    });
    </script>
</header>
