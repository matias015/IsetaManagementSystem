@extends('Admin.template')

@section('content')
    <div>
        <div class="perfil_one br">
            <div class="perfil__header">
                <h2>Crear nuevo profesor/a</h2>
            </div>
            <div class="perfil__info">
                <form method="post" action="{{route('admin.profesores.store')}}">
                @csrf
                    <div class="perfil_dataname">
                        <label>DNI:</label>
                        <input class="campo_info rounded"  name="dni">
                    </div>
                    <div class="perfil_dataname">
                        <label>Nombre:</label>
                        <input class="campo_info rounded" name="nombre">
                    </div>
                    <div class="perfil_dataname">
                        <label>Apellido:</label>
                        <input class="campo_info rounded" name="apellido">
                    </div>
                    <div class="perfil_dataname">
                        <label>Fecha nacimiento:</label>
                        <input class="campo_info rounded" type="date" name="fecha_nacimiento">
                    </div>
                    <div class="perfil_dataname">
                        <label>Ciudad:</label>
                        <input class="campo_info rounded" value="9 de Julio" name="ciudad">
                    </div>
                    <div class="perfil_dataname">
                        <label>Calle:</label>
                        <input class="campo_info rounded" name="calle">
                    </div>
                    <div class="perfil_dataname">
                        <label>Numero:</label>
                        <input class="campo_info rounded"  name="casa_numero">
                    </div>
                    <div class="perfil_dataname">
                        <label>Departamento:</label>
                        <input class="campo_info rounded" name="dpto">
                    </div>
                    <div class="perfil_dataname">
                        <label>Piso:</label>
                        <input class="campo_info rounded" name="piso">
                    </div>
                    <div class="perfil_dataname">
                        <label>Estado civil:</label>
                        <select input class="campo_info rounded" name="estado_civil">
                            <option selected value="0">Soltero</option>
                            <option value="1">Casado</option>
                        </select>
                    </div>
                    <div class="perfil_dataname">
                        <label>Email:</label>
                        <input class="campo_info rounded" value="@gmail.com" name="email">
                    </div>
                    <div class="perfil_dataname">
                        <label>Formacion academica:</label>
                        <input class="campo_info rounded" name="formacion_academica">
                    </div>
                    <div class="perfil_dataname">
                        <label>Titulo:</label>
                        <input class="campo_info rounded" name="titulo">
                    </div>
                    <div class="perfil_dataname">
                        <label>Año de ingreso:</label>
                        <input class="campo_info rounded" name="anio_ingreso">
                    </div>
                    <div class="perfil_dataname">
                        <label>Observaciones:</label>
                        <textarea name="observaciones" cols="30" rows="10"></textarea>
                    </div>
                    <div class="perfil_dataname">
                        <label>Telefono:</label>
                        <input class="campo_info rounded" value="2317" name="telefono1">
                    </div>
                    <div class="perfil_dataname">
                        <label>Telefono 2:</label>
                        <input class="campo_info rounded" name="telefono2">
                    </div>
                    <div class="perfil_dataname">
                        <label>Telefono 3:</label>
                        <input class="campo_info rounded" name="telefono3">
                    </div>
                    <div class="perfil_dataname">
                        <label>Codigo postal:</label>
                        <input class="campo_info rounded" value="6500" name="codigo_postal">
                    </div>
                    <div class="upd"><input class="btn_borrar upd" type="submit" value="Crear"></div>
                </form>
            </div>
        </div>
    </div>
@endsection
