@extends('Admin.template')

@section('content')
    <div>
        @if ($errors -> any())
            @foreach ($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif


       <form method="post" action="{{route('admin.carreras.update', ['carrera'=>$carrera->id])}}">
        @csrf
        @method('put')

        <p>carrera <input value="{{$carrera->nombre}}" name="nombre"></p>
        <p>resolucion <input value="{{$carrera->resolucion}}" name="resolucion"></p>
        <p>anio_apertura <input value="{{$carrera->anio_apertura}}" name="anio_apertura"></p>
        <p>anio_fin <input value="{{$carrera->anio_fin}}" name="anio_fin"></p>
        <p>observaciones <input value="{{$carrera->observaciones}}" name="observaciones"></p>

        <input type="submit" value="Actualizar">
       </form>
    </div>
@endsection