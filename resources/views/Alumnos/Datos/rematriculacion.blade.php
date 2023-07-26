@extends('Alumnos.layout')
@section('content')
<div class="p-2">
    <form method="POST" action="{{route('alumno.rematriculacion.post')}}">
        @csrf

        @foreach ($asignaturas as $asignatura)
            <div class="w-100p grid-2">
                <span>{{$asignatura->nombre}}</span>
                <span>
                    <select name="{{$asignatura->id}}">
                        <option selected value="0">Selecciona</option>
                        <option value="1">Presencial</option>
                        <option value="2">Libre</option>
                    </select>
                </span>
            </div>
            <hr>
        @endforeach
        <button>Enviar</button>
    </form>
</div>
@endsection