<aside class="none lg-block admin-aside">
    
    <ul class="p-3 admin-aside-ul">
        <h1 class="logo-iseta">ISETA Admin</h1>
        <li><a class="text-blue-600" href="{{route('admin.alumnos.index')}} "><i class="ti ti-user"></i>Alumnos</a></li>
        <li><a class="text-blue-600" href="{{route('admin.profesores.index')}}"><i class="ti ti-users"></i>    Profesores  </a></li>
        <li><a class="text-blue-600" href="{{route('admin.carreras.index')}}">      Carreras    </a></li>
        {{-- <li><a class="text-blue-600" href="{{route('admin.asignaturas.index')}}">   Asignaturas </a></li> --}}
        <li><a class="text-blue-600" href="{{route('admin.mesas.index')}}"><i class="ti ti-clipboard-text"></i>         Mesas       </a></li>
        {{-- <li><a class="text-blue-600" href="{{route('admin.examenes.index')}}"><i class="ti ti-address-book"></i>      Examenes    </a></li> --}}
        <li><a class="text-blue-600" href="{{route('admin.cursadas.index')}}"><i class="ti ti-books"></i></i>      Cursadas    </a></li>
        <li><a class="text-blue-600" href="{{route('admin.egresados.index')}}"><i class="ti ti-school"></i>      Egresados    </a></li>
        <hr>
        <li><a class="text-blue-600" href="{{route('admin.admins.index')}}  "><i class="ti ti-user-cog"></i>      Admins      </a></li>
        <li><a class="text-blue-600" href="{{route('admin.config.index')}}  "><i class="ti ti-settings"></i>      Configuracion      </a></li>
        <li><a class="text-blue-600" href="{{route('admin.habiles.index')}}  "><i class="ti ti-calendar-time"></i>      Dias habiles      </a></li>

        <li class="perfil-lista-item"><a href="/admin/logout"><i class="ti ti-logout"></i> Cerrar sesion</a></li>
    </ul>
    
</aside>
