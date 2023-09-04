@extends('Admin.template')

@section('content')
    <div>
        @if ($errors -> any())
            @foreach ($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif

        <div class="perfil_one table">
       <form method="post" action="{{route('admin.carreras.store')}}">
        @csrf

        <span class="perfil_dataname">Carrera: <input class="campo_info" name="nombre"></span>
        <span class="perfil_dataname">Resolucion: <input class="campo_info" name="resolucion"></span>
        <span class="perfil_dataname">Año apertura: <input class="campo_info" name="anio_apertura"></span>
        <span class="perfil_dataname">Año fin: <input class="campo_info" name="anio_fin"></span>
        <span class="perfil_dataname">Observaciones: <input class="campo_info" name="observaciones"></span>

        <div class="upd"><input class="btn_borrar upd" type="submit" value="Crear"></div>
       </form>
        </div>
    </div>
@endsection
