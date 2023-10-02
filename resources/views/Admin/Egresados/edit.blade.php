@extends('Admin.template')

@section('content')
    <div>

        <div class="perfil_one table">
           
       <form method="post" action="{{route('admin.egresados.update', ['egresado' => $registro->id])}}">
        @csrf
        @method('put')

       
        <span class="perfil_dataname">Alumno:
                {{$textFormatService->ucwords($registro->alumno->apellido.' '.$registro->alumno->nombre)}}
        </span>
    
        <span class="perfil_dataname">Carrera:
            {{$textFormatService->ucwords($registro->carrera->nombre)}}

        </span>

        <span class="perfil_dataname">Año inscripcion: <input class="campo_info" value="{{$registro->anio_inscripcion}}" name="anio_inscripcion"></span>
        <span class="perfil_dataname">Indice libro matriz: <input class="campo_info" value="{{$registro->indice_libro_matriz}}" name="indice_libro_matriz"></span>
        <span class="perfil_dataname">Año finalizacion: <input class="campo_info" value="{{$registro->anio_finalizacion}}" name="anio_finalizacion"></span>


        <div class="upd"><input class="btn_borrar upd" type="submit" value="Editar"></div>
       </form>
        </div>
    </div>
@endsection
