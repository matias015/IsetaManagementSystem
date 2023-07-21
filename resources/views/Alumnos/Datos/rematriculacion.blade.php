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

    <table>
        <thead>
            <tr>
                <td>Asignatura</td>
                <td>tipo</td>
            </tr>
        </thead>
        <form method="POST" id="form" action="{{route('alumno.rematriculacion.post')}}">
            @csrf
            <tbody id="body-table">
                
            </tbody>
        </form>
    </table>

    <input form="form" type="submit" value="Remat">

    <script src="{{asset('js/mostrar-materias-remat.js')}}"></script>
@endif
@endsection