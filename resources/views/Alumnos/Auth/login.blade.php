@extends('Alumnos.layout')

@section('content')
    <form method="POST" action="{{route('alumno.login.post')}}">
        @csrf
        <input name="email">
        <input name="password">
        <input type="submit" value="login">
    </form>
@endsection