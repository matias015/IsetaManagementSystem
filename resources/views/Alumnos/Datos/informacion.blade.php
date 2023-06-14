@extends('Alumnos.layout')
@section('content')
<main>
  <section class="perfil">
    <div class="perfil_header">
      <i class="uil uil-user"></i>
      <h1>Perfil</h1>
    </div>
    <div class="perfil_body">
      <div class="perfil_one">
        <div class="perfil_subtop"><h2>Información alumno</h2></div>
        <span class="perfil_dataname">Nombres: <b class="perfil_datainfo">{{$alumno->nombre}}</b></span>
        <span class="perfil_dataname">Apellidos: <b class="perfil_datainfo">{{$alumno->apellido}}</b></span>
        <span class="perfil_dataname">Mail: <b class="perfil_datainfo">{{$alumno->email}}</b></b></span>
        <span class="perfil_dataname">DNI: <b class="perfil_datainfo">{{$alumno->dni}}</b></span>
        <span class="perfil_dataname">Telefono: <b class="perfil_datainfo">{{$alumno->telefono1}}</b></span>
        <span class="perfil_dataname">Telefono 2: <b class="perfil_datainfo">{{$alumno->telefono2? $alumno->telefono2:'No tienes un numero alternativo'}}</b></span>
        <span class="perfil_dataname">Telefono 3: <b class="perfil_datainfo">{{$alumno->telefono3? $alumno->telefono3:'No tienes un segundo numero alternativo'}}</b></span>
        <span class="perfil_dataname">Dirección: <b class="perfil_datainfo">{{$alumno->calle?$alumno->calle:'Sin datos de la direccion'}}</b></span>
        @if ($alumno->casa_numero)
          <span class="perfil_dataname">Numero: <b class="perfil_datainfo">{{$alumno->casa_numero}}</b></span>
        @endif
      </div>
      
    <form action="{{route('cambio.password')}}" method="POST">
      @csrf
      
      <div class="perfil_second">
        <div class="perfil_subtop"><h2>Editar contraseña</h2></div>
        <div class="perfil_password">
          <input type="password" name="oldPassword"  required placeholder="Contraseña actual">
          <i class="ti ti-circle-check-filled check_pos"></i>
          <i class="ti ti-circle-x-filled check_neg"></i>
        </div>
        <div class="perfil_password">
          <input type="password" name="newPassword"  required placeholder="Nueva contraseña">
          <i class="ti ti-circle-check-filled check_pos"></i>
          <i class="ti ti-circle-x-filled check_neg"></i>
        </div>
        <div class="perfil_password">
          <input type="password" name="newPassword_confirm"  required placeholder="Confirmar contraseña">
          <i class="ti ti-circle-check-filled check_pos"></i>
          <i class="ti ti-circle-x-filled check_neg"></i>
        </div>
      </div>
      <button>Cambiar</button>
    </form>

      <div class="perfil_third">
        <div class="perfil_subtop"><h2>Academico</h2></div>
        <div class="perfil_descargable v">
          <span>Informe analitico</span>
          <button><i class="ti ti-eye"></i>Ver</button>
        </div>
        <div class="perfil_descargable d">
          <span>Constancia de inscripción a mesas de examen</span>
          <button><i class="ti ti-download"></i>Descargar</button>
        </div>
        
      </div>
    </div>
  </section>
  
</main>
@endsection
