@extends('Admin.template')

@section('content')

    <div>

        <form action="{{route('admin.config.set',['clave' => 'filas_por_tabla'])}}">
            <p>Filas por tabla <input name="value" value="{{$configuracion['filas_por_tabla'] ? $configuracion['filas_por_tabla'] : ''}}" name="filas_por_tabla"></p>
        </form>

    </div>
    
@endsection
