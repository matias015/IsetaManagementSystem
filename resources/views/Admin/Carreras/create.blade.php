@extends('Admin.template')

@section('content')
    <div>
        @if ($errors -> any())
            @foreach ($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif


       <form method="post" action="{{route('admin.carreras.store')}}">
        @csrf

        <p>carrera <input name="nombre"></p>
        <p>resolucion <input name="resolucion"></p>
        <p>anio_apertura <input name="anio_apertura"></p>
        <p>anio_fin <input name="anio_fin"></p>
        <p>observaciones <input name="observaciones"></p>

        <input type="submit" value="Crear">
       </form>
    </div>
@endsection