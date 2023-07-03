@extends('Admin.template')

@section('content')

    <div>

        <form action="{{route('admin.config.set',['clave' => 'filas_por_tabla'])}}">
            <p>Filas por tabla <input name="value" value="{{$configuracion['filas_por_tabla'] ? $configuracion['filas_por_tabla'] : ''}}" name="filas_por_tabla"></p>
        </form>

        <form action="{{route('admin.config.set',['clave' => 'horas_habiles_inscripcion'])}}">
            <p>Dias habiles de inscripcion <input name="value" value="{{$configuracion['horas_habiles_inscripcion'] ? $configuracion['horas_habiles_inscripcion'] : ''}}" name="filas_por_tabla"></p>
        </form>

        <form action="{{route('admin.config.set',['clave' => 'horas_habiles_desinscripcion'])}}">
            <p>Dias habiles de desinscripcion <input name="value" value="{{$configuracion['horas_habiles_desinscripcion'] ? $configuracion['horas_habiles_desinscripcion'] : ''}}" name="filas_por_tabla"></p>
        </form>

    </div>
    
@endsection
