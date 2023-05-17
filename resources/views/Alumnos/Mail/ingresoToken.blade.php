@extends('Alumnos.layout')
@section('content')
    
<p><a href="{{route('token.enviar.mail')}}"><button>Enviar mail</button></a></p>

<form method="POST" action="{{route('token.ingreso.post')}}">
    @csrf
    token
    <input name="token">
    <input type="submit" value="enviar">
</form>
@endsection
