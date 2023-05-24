@extends('Alumnos.layout')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>

<h1>login alumnos</h1>
    <form method="POST" action="{{route('alumno.login.post')}}">
        @csrf
        <input name="email">
        <input name="password">
        <input type="submit" value="login">
    </form>
@endsection