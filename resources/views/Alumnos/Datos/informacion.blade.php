@extends('Alumnos.layout')
@include('Comp/header')

@section('content')
    {{$alumno}}
    <form method="POST" action="{{route('alumno.set.default')}}">
        @csrf
        <select name="carrera" style="height: 5vh;">
            @foreach($carreras as $carrera)
                <option @if($default && $default == $carrera->id) selected @endif value="{{$carrera->id}}">{{$textFormatService->utf8Minusculas($carrera->nombre)}}</option>
            @endforeach
        </select>
        <input type="submit" value="Seleccionar">
            
    </form>
@endsection