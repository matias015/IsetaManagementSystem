<aside class="none lg-block admin-aside">
    
    <ul class="p-3 admin-aside-ul">
        <p class="logo-iseta">ISETA Admin</p>
        <li><a class="text-blue-600" href="{{route('admin.alumnos.index')}} "><i class="ti ti-user"></i>      Alumnos     </a></li>
        <li><a class="text-blue-600" href="{{route('admin.profesores.index')}}"><i class="ti ti-users"></i>    Profesores  </a></li>
        <li><a class="text-blue-600" href="{{route('admin.carreras.index')}}">      Carreras    </a></li>
        <li><a class="text-blue-600" href="{{route('admin.asignaturas.index')}}">   Asignaturas </a></li>
        <li><a class="text-blue-600" href="{{route('admin.mesas.index')}}"><i class="ti ti-clipboard-text"></i>         Mesas       </a></li>
        <li><a class="text-blue-600" href="{{route('admin.examenes.index')}}"><i class="ti ti-address-book"></i>      Examenes    </a></li>
        <li><a class="text-blue-600" href="{{route('admin.cursadas.index')}}"><i class="ti ti-books"></i></i>      Cursadas    </a></li>
        <li><a class="text-blue-600" href="{{route('admin.egresados.index')}}"><i class="ti ti-school"></i>      Egresados    </a></li>
        <hr>
        <li><a class="text-blue-600" href="{{route('admin.admins.index')}}  "><i class="ti ti-user-cog"></i>      Admins      </a></li>
        <li><a class="text-blue-600" href="{{route('admin.config.index')}}  "><i class="ti ti-settings"></i>      Configuracion      </a></li>
        
        <li class="none">    
            <i class="ti ti-sun-filled"></i>
            <i class="ti ti-moon"></i>
            <div id="mode-dark_light">
                <div class="toggle"></div>
            </div>
        </li>
        

        
    </ul>

    <script>
        var toggle = document.getElementById('mode-dark_light')
        var body = document.querySelector('body')
        var aside = document.querySelector('aside')
        var iseta = document.querySelector('p')
        var a = document.querySelector('a')
        var icon_sun = document.querySelector('.ti-sun-filled')
        var icon_moon = document.querySelector('.ti-moon')

        toggle.onclick = function(){
            
            toggle.classList.toggle('active');
            body.classList.toggle('active');
            aside.classList.toggle('active');
            iseta.classList.toggle('active');
            a.classList.toggle('active');
            icon_sun.classList.toggle('active');
            icon_moon.classList.toggle('active');
        }
    </script>

</aside>
