@extends('Admin.template')

@section('content')
    <div>
        @if ($errors -> any())
            @foreach ($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif


       <form method="post" action="{{route('admin.egresados.store')}}">
        @csrf

       
        <h2>alumno</h2>
        <select name="id_alumno">
            @foreach ($alumnos as $alumno)
                <option value="{{$alumno->id}}">{{$textFormatService->utf8UpperCamelCase($alumno->nombre.' '.$alumno->apellido)}}</option>
            @endforeach
        </select>
<br>
<h2>carrera</h2>
        <select name="id_carrera">
            @foreach ($carreras as $carrera)
                <option value="{{$carrera->id}}">{{$textFormatService->utf8minusculas($carrera->nombre)}}</option>
            @endforeach
        </select>

        <p>año inscripcion <input name="anio_inscripcion"></p>
        <p>indice_libro_matriz <input name="indice_libro_matriz"></p>
        <p>anio_finalizacion <input name="anio_finalizacion"></p>

        <br><br>
        <input type="submit" value="Crear">
       </form>
    </div>
@endsection
