@extends('Admin.template')

@section('content')
    <div>
        <div class="perfil_one br">
            <div class="perfil__header">
                <h2>Crear nuevo alumno/a</h2>
            </div>
            <div class="perfil__info">
                <form method="post" action="{{route('admin.alumnos.store')}}">
                @csrf
                    
                    <div class="perfil_dataname">
                        <label>DNI:</label>
                        <input class="px-2 campo_info rounded" value="{{old('dni')}}" name="dni">
                    </div>
                    <div class="perfil_dataname">
                        <label>Nombre:</label>
                        <input class="campo_info rounded" value="{{old('nombre')}}" name="nombre">
                    </div>
                    <div class="perfil_dataname">
                        <label>Apellido:</label>
                        <input class="campo_info rounded" value="{{old('apellido')}}" name="apellido">
                    </div>
                    <div class="perfil_dataname">
                        <label>Fecha de nacimiento:</label>
                        <input  class="campo_info rounded" type="date" value="{{old('fecha_nacimiento')}}" name="fecha_nacimiento">
                    </div>
                    <div class="perfil_dataname">
                        <label>Ciudad:</label>
                        <input class="campo_info rounded" value="{{old('ciudad')}}" name="ciudad">
                    </div>
                    <div class="perfil_dataname">
                        <label>Calle:</label>
                        <input class="campo_info rounded" value="{{old('calle')}}" name="calle">
                    </div>
                    <div class="perfil_dataname">
                        <label>Numero:</label>
                        <input class="campo_info rounded" value="{{old('casa_numero')}}" name="casa_numero">
                    </div>
                    <div class="perfil_dataname">
                        <label>Departamento:</label>
                        <input class="campo_info rounded" value="{{old('dpto')}}" name="dpto">
                    </div>
                    <div class="perfil_dataname">
                        <label>Piso:</label>
                        <input class="campo_info rounded" value="{{old('piso')}}" name="piso">
                    </div>
                    <div class="perfil_dataname">
                        <label>Estado civil:</label>
                        <select class="campo_info rounded" name="estado_civil">
                            <option {{ old('estado_civil') == '0' ? 'selected' : '' }} value="0">Soltero</option>
                            <option {{ old('estado_civil') == '1' ? 'selected' : '' }} value="1">Casado</option>
                        </select>
                    </div>
                    <div class="perfil_dataname">
                        <label>Email:</label>
                        <input class="campo_info rounded" value="{{old('email')}}" name="email">
                    </div>
                    <div class="perfil_dataname">
                        <label>Titulo anterior:</label>
                        <input class="campo_info rounded" value="{{old('titulo_anterior')}}" name="titulo_anterior">
                    </div>
                    <div class="perfil_dataname">
                        <label>Becas:</label>
                        <input class="campo_info rounded" value="{{old('becas')}}" name="becas">
                    </div>
                    <div class="perfil_dataname">
                        <label>Observaciones:</label>
                        <textarea value="{{old('observaciones')}}" name="observaciones" cols="30" rows="10"></textarea>
                    </div>
                    <div class="perfil_dataname">
                        <label>Telefono:</label>
                        <input class="campo_info rounded" value="{{old('telefono1')}}" name="telefono1">
                    </div>
                    <div class="perfil_dataname">
                        <label>Telefono 2:</label>
                        <input class="campo_info rounded" value="{{old('telefono2')}}" name="telefono2">
                    </div>
                    <div class="perfil_dataname">
                        <label>Telefono 3:</label>
                        <input class="campo_info rounded" value="{{old('telefono3')}}" name="telefono3">
                    </div>
                    <div class="perfil_dataname">
                        <label>Codigo postal:</label>
                        <input class="campo_info rounded" value="{{old('codigo_postal')}}" name="codigo_postal">
                    </div>

                    <div class="upd"><input class="btn_borrar upd" type="submit" value="Crear"></div>
                </form>
            </div>
        </div>
    </div>
@endsection
