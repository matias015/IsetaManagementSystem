@extends('Admin.template')

@section('content')
    <div>
        @if ($errors -> any())
            @foreach ($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif

        <div class="perfil_one table">
       <form method="post" action="{{route('admin.profesores.store')}}">
        @csrf

        <span class="perfil_dataname">DNI: <input class="campo_info"  name="dni"></span>
        <span class="perfil_dataname">Nombre: <input class="campo_info" name="nombre"></span>
        <span class="perfil_dataname">Apellido: <input class="campo_info" name="apellido"></span>
        <span class="perfil_dataname">Fecha nacimiento: <input class="campo_info" type="date" name="fecha_nacimiento"></span>
        <span class="perfil_dataname">Ciudad: <input class="campo_info" value="9 de Julio" name="ciudad"></span>
        <span class="perfil_dataname">Calle: <input class="campo_info" name="calle"></span>
        <span class="perfil_dataname">Numero: <input class="campo_info"  name="casa_numero"></span>
        <span class="perfil_dataname">Departamento: <input class="campo_info" name="dpto"></span>
        <span class="perfil_dataname">Piso: <input class="campo_info" name="piso"></span>
        <span class="perfil_dataname">
            Estado civil: 
            <select input class="campo_info" name="estado_civil">
                <option selected value="0">Soltero</option>
                <option value="1">Casado</option>
            </select>
        </span>
        <span class="perfil_dataname">Email: <input class="campo_info" value="@gmail.com" name="email"></span>
        <span class="perfil_dataname">Formacion academica: <input class="campo_info" name="formacion_academica"></span>
        <span class="perfil_dataname">Titulo: <input class="campo_info" name="titulo"></span>
        <span class="perfil_dataname">Año de ingreso: <input class="campo_info" name="anio_ingreso"></span>

        <span class="perfil_dataname">Observaciones: <textarea name="observaciones" cols="30" rows="10"></textarea></span>

        <span class="perfil_dataname">Telefono: <input class="campo_info" value="2317" name="telefono1"></span>
        <span class="perfil_dataname">Telefono 2: <input class="campo_info" name="telefono2"></span>
        <span class="perfil_dataname">Telefono 3:<input class="campo_info" name="telefono3"></span>
        <span class="perfil_dataname">Codigo postal:<input class="campo_info" value="6500" name="codigo_postal"></span>

        <div class="upd"><input class="btn_borrar upd" type="submit" value="Crear"></div>
       </form>
       </div>
    </div>
@endsection
