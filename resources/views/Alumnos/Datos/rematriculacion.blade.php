@extends('Alumnos.layout')
@section('content')

@if (!$en_fecha)
    <h1>No es fecha de rematriculacion</h1>
@else
    <select id="carrera_select">
        <option selected value="0">Selecciona una carrera</option>
        @foreach ($carreras as $carrera)
            <option value="{{$carrera->id}}">{{$textFormatService->utf8Minusculas($carrera->nombre)}}</option>
        @endforeach
    </select>

    <form action="">
        <select id="asignatura_select">
            <option selected value="">Selecciona una carrera</option>
        </select>
    </form>

    <script src="{{asset('js/obtener-materias.js')}}"></script>
@endif
@endsection