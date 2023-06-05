@extends('Admin.template')

@section('content')
    <div>
        @if ($errors -> any())
            @foreach ($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif

<div class="edit-form-container">
       <form method="post" action="{{route('admin.profesores.update', ['profesor'=>$profesor->id])}}">
        @csrf
        @method('put')

        <p>dni <input value="{{$profesor->dni}}" name="dni"></p>
        <p>nombre <input value="{{$profesor->nombre}}" name="nombre"></p>
        <p>apellido <input value="{{$profesor->apellido}}" name="apellido"></p>
        <p>fecha nacimiento <input value="{{$profesor->fecha_nacimiento->format('Y-m-d')}}" type="date" name="fecha_nacimiento"></p>
        <p>ciudad <input value="{{$profesor->ciudad}}" value="9 de Julio" name="ciudad"></p>
        <p>calle <input value="{{$profesor->calle}}" name="calle"></p>
        <p>numero <input value="{{$profesor->numero}}"  name="casa_numero"></p>
        <p>departamento <input value="{{$profesor->departamento}}" name="dpto"></p>
        <p>piso <input value="{{$profesor->piso}}" name="piso"></p>
        <p>
            estado civil 
            <select name="estado_civil">
                <option @if($profesor->estado_civil==0) selected @endif value="0">soltero</option>
                <option @if($profesor->estado_civil==1) selected @endif value="1">casado</option>
            </select>
        </p>
        <p>email <input value="{{$profesor->email}}" name="email"></p>
        <p>formacion academica <input value="{{$profesor->formacion_academica}}" name="formacion_academica"></p>
        <p>año de ingreso <input value="{{$profesor->anio_ingreso}}" name="anio_ingreso"></p>
        
        <p>observaciones <textarea value="{{$profesor->observaciones}}" name="observaciones" cols="30" rows="10"></textarea></p>

        <p>telefono <input value="{{$profesor->telefono1}}" name="telefono1"></p>
        <p>telefono 2 <input value="{{$profesor->telefono2}}" name="telefono2"></p>
        <p>telefono 3<input value="{{$profesor->telefono3}}" name="telefono3"></p>
        <p>codigo postal<input value="{{$profesor->codigo_postal}}" value="6500" name="codigo_postal"></p>

        <input type="submit" value="Actualizar">
       </form>
    </div></div>
@endsection