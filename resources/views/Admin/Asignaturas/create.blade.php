@extends('Admin.template')

@section('content')
    <div>
        @if ($errors -> any())
            @foreach ($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif


       <form method="post" action="{{route('admin.asignaturas.store')}}">
        @csrf

        <p>asignatura <input name="nombre"></p>
        
        <select name="id_carrera">
            @foreach($carreras as $carrera)
                <option value="{{$carrera->id}}">{{$carrera->nombre}}</option>
            @endforeach
        </select>
        <p>tipo modulo <input  name="tipo_modulo"></p>
        <p>carga horaria <input  name="carga_horaria"></p>
        <p>año<input  name="anio"></p>
        <p>observaciones <input  name="observaciones"></p>


        <input type="submit" value="Crear">
       </form>
    </div>
@endsection