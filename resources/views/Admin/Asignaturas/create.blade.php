@extends('Admin.template')

@section('content')
    <div>
        @if ($errors -> any())
            @foreach ($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif

        <div class="perfil_one table">
       <form method="post" action="{{route('admin.asignaturas.store')}}">
        @csrf

        <span class="perfil_dataname">Asignatura <input class="campo_info" name="nombre"></span>
        <span class="perfil_dataname">Carrera:
        <select class="campo_info" name="id_carrera">
            @foreach($carreras as $carrera)
                <option @selected($id_carrera==$carrera->id) value="{{$carrera->id}}">{{$carrera->nombre}}</option>
            @endforeach
        </select>
        </span>
        <span class="perfil_dataname">Tipo modulo: <input class="campo_info"  name="tipo_modulo"></span>
        <span class="perfil_dataname">Carga horaria: <input class="campo_info"  name="carga_horaria"></span>
        <span class="perfil_dataname">Año:<input class="campo_info"  name="anio"></span>
        <span class="perfil_dataname">Observaciones: <input class="campo_info"  name="observaciones"></span>


        <div class="upd"><input class="btn_borrar upd" type="submit" value="Crear"></div>
       </form>
        </div>
    </div>
@endsection
