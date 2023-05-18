@extends('Alumnos.layout')

@section('content')
<h1>Registro</h1>
    <form method="POST" action="{{route('alumno.registro.post')}}">
        @csrf
        <input name="email">
        <input name="password">
        <input type="submit" value="login">
    </form>

    
@endsection