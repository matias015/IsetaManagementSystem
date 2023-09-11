@extends('Admin.template')

@section('content')
    <div>

        <div class="perfil_one table">
       <form method="post" action="{{route('admin.alumnos.store')}}">
        @csrf

        <span class="perfil_dataname">DNI: <input class="boder" value="{{old('dni')}}" name="dni"></span>
        <span class="perfil_dataname">Nombre: <input class="campo_info" value="{{old('nombre')}}" name="nombre"></span>
        <span class="perfil_dataname">Apellido: <input class="campo_info" value="{{old('apellido')}}" name="apellido"></span>
        <span class="perfil_dataname">Fecha nacimiento: <input  class="campo_info" type="date" value="{{old('fecha_nacimiento')}}" name="fecha_nacimiento"></span>
        <span class="perfil_dataname">Ciudad: <input class="campo_info" value="{{old('ciudad')}}" name="ciudad"></span>
        <span class="perfil_dataname">Calle: <input class="campo_info" value="{{old('calle')}}" name="calle"></span>
        <span class="perfil_dataname">Numero: <input class="campo_info" value="{{old('casa_numero')}}" name="casa_numero"></span>
        <span class="perfil_dataname">Departamento: <input class="campo_info" value="{{old('dpto')}}" name="dpto"></span>
        <span class="perfil_dataname">Piso: <input class="campo_info" value="{{old('piso')}}" name="piso"></span>
        <span class="perfil_dataname">
            Estado civil: 
            <select class="campo_info" name="estado_civil">
                <option {{ old('estado_civil') == '0' ? 'selected' : '' }} value="0">Soltero</option>
                <option {{ old('estado_civil') == '1' ? 'selected' : '' }} value="1">Casado</option>
            </select>
        </span>
        <span class="perfil_dataname">Email: <input class="campo_info" value="{{old('email')}}" name="email"></span>
        <span class="perfil_dataname">Titulo anterior: <input class="campo_info" value="{{old('titulo_anterior')}}" name="titulo_anterior"></span>
        <span class="perfil_dataname">Becas: <input class="campo_info" value="{{old('becas')}}" name="becas"></span>
        
        <span class="perfil_dataname">Observaciones: <textarea value="{{old('observaciones')}}" name="observaciones" cols="30" rows="10"></textarea></span>

        <span class="perfil_dataname">Telefono: <input class="campo_info" value="{{old('telefono1')}}" name="telefono1"></span>
        <span class="perfil_dataname">Telefono 2: <input class="campo_info" value="{{old('telefono2')}}" name="telefono2"></span>
        <span class="perfil_dataname">Telefono 3:<input class="campo_info" value="{{old('telefono3')}}" name="telefono3"></span>
        <span class="perfil_dataname">Codigo postal:<input class="campo_info" value="{{old('codigo_postal')}}" name="codigo_postal"></span>

        <div class="upd"><input class="btn_borrar upd" type="submit" value="Crear"></div>
       </form>
       </div>
    </div>
@endsection
