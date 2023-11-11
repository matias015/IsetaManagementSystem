<footer class="font-1 md-font-3">
    <div class="footer-contenido">
      <section class="footer-logos grid-1 gap-2 just-center lg-flex lg-just-between">
        <div class="logo-footer center">
          <span class="font-6">{{$config['nombre']}}</span>
        </div>
        <div class="footer-redes flex just-center">
          <span>Seguinos en nuestras redes</span>
          <ul>
            <li>
              <a class="col-fb" href="https://www.facebook.com/iseta9dejulio/" target="_blank"><i class="ti ti-brand-facebook-filled"></i></a>
            </li>
            <li>
              <a class="col-ig" href="https://www.instagram.com/isft.iseta/" target="_blank"><i class="ti ti-brand-instagram"></i></a>
            </li>
            <li>
              <a class="col-yt" href="https://iseta.edu.ar/sitio/" target="_blank"><i class="ti ti-world"></i></a>
            </li>
          </ul>
        </div>
      </section>
      <section class="footer-texto grid-1 md-grid-2 sm-grid-2 lg-grid-4">
        <article class="footer-info">
          <h3>Explorar</h3>
          <ul class="box">
            <li><a href="{{route('alumno.info')}}">Perfil</a></li>
            <li><a href="{{route('alumno.cursadas')}}">Cursadas</a></li>
            <li><a href="{{route('alumno.examenes')}}">Examenes</a></li>
            <li><a href="{{route('alumno.inscripciones')}}">Inscribir</a></li>
          </ul>
        </article>
        <article class="footer-info">
          <h3>Correos</h3>
          <ul class="box">
            @if ($config['correo1'])
                <li>{{$config['correo1']}}</li>
            @endif
            
            @if ($config['correo2'])
                <li>{{$config['correo2']}}</li>
            @endif
            
            @if ($config['correo3'])
                <li>{{$config['correo3']}}</li>
            @endif
          </ul>
        </article>
        <article class="footer-info">
          <h3>Telefonos</h3>
          <ul class="box">
            @if ($config['telefono1'])
                <li>{{$config['telefono1']}}</li>
            @endif
            
            @if ($config['telefono2'])
                <li>{{$config['telefono2']}}</li>
            @endif
            
            @if ($config['telefono3'])
                <li>{{$config['telefono3']}}</li>
            @endif
          </ul>
        </article>
        <article class="footer-info">
          <h3>Más información</h3>
          <ul class="box">
            <li>{{$config['mas_info1']}}</li>
            <li>{{$config['mas_info2']}}</li>
            <li>{{$config['mas_info3']}}</li>
            {{-- <li>Lunes a Viernes de 8 a 22.40 hs</li> --}}
          </ul>
        </article>
      </section>
    </div>
    <div class="p-2 footer-derechos">
        <span class="center">Copyright © 2023<a class="neg" href="#">{{$config['nombre']}}</a> | Todos los derechos reservados</span>
        <span class="flex gap-4 just-center">
          Desarrolado por los alumnos de tercer año de Análisis, Desarrollo y Programación de Aplicaciones
        </span>
    </div>
  </footer>
