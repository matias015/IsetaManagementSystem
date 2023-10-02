@extends('Admin.template')

@section('content')
    <div>

        <div class="perfil_one table">

       <form method="post" action="{{route('admin.egresados.store')}}">
        @csrf

       
        <span class="perfil_dataname">Alumno:
        <select class="campo_info" name="id_alumno">
            @foreach ($alumnos as $alumno)
                <option value="{{$alumno->id}}">{{$textFormatService->ucwords($alumno->apellido.' '.$alumno->nombre)}}</option>
            @endforeach
        </select>
        </span>
    
        <span class="perfil_dataname">Carrera:
        <select class="campo_info" name="id_carrera">
            @foreach ($carreras as $carrera)
                <option value="{{$carrera->id}}">{{$textFormatService->ucfirst($carrera->nombre)}}</option>
            @endforeach
        </select>
        </span>

        <span class="perfil_dataname">Año inscripcion: <input class="campo_info"  name="anio_inscripcion"></span>
        <span class="perfil_dataname">Indice libro matriz: <input class="campo_info" name="indice_libro_matriz"></span>
        <span class="perfil_dataname">Año finalizacion: <input class="campo_info" name="anio_finalizacion"></span>


        <div class="upd"><input class="btn_borrar upd" type="submit" value="Crear"></div>
       </form>
        </div>
    </div>
@endsection
