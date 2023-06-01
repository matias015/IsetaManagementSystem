@extends('Admin.template')

@section('content')
    <div>
        @if ($errors -> any())
            @foreach ($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif


       <form method="post" action="{{route('admin.alumnos.update', ['alumno'=>$alumno->id])}}">
        @csrf
        @method('put')

        <p>dni <input value="{{$alumno->dni}}" name="dni"></p>
        <p>nombre <input value="{{$alumno->nombre}}" name="nombre"></p>
        <p>apellido <input value="{{$alumno->apellido}}" name="apellido"></p>
        <p>fecha nacimiento <input value="{{$alumno->fecha_nacimiento->format('Y-m-d')}}" type="date" name="fecha_nacimiento"></p>
        <p>ciudad <input value="{{$alumno->ciudad}}" value="9 de Julio" name="ciudad"></p>
        <p>calle <input value="{{$alumno->calle}}" name="calle"></p>
        <p>numero <input value="{{$alumno->numero}}"  name="casa_numero"></p>
        <p>departamento <input value="{{$alumno->departamento}}" name="dpto"></p>
        <p>piso <input value="{{$alumno->piso}}" name="piso"></p>
        <p>
            estado civil 
            <select name="estado_civil">
                <option @if($alumno->estado_civil==0) selected @endif value="0">soltero</option>
                <option @if($alumno->estado_civil==1) selected @endif value="1">casado</option>
            </select>
        </p>
        <p>email <input value="{{$alumno->email}}" name="email"></p>
        <p>titulo anterior <input value="{{$alumno->titulo_anterior}}" name="titulo_anterior"></p>
        <p>becas <input value="{{$alumno->becas}}" name="becas"></p>
        
        <p>observaciones <textarea value="{{$alumno->observaciones}}" name="observaciones" cols="30" rows="10"></textarea></p>

        <p>telefono <input value="{{$alumno->telefono1}}" name="telefono1"></p>
        <p>telefono 2 <input value="{{$alumno->telefono2}}" name="telefono2"></p>
        <p>telefono 3<input value="{{$alumno->telefono3}}" name="telefono3"></p>
        <p>codigo postal<input value="{{$alumno->codigo_postal}}" value="6500" name="codigo_postal"></p>

        <input type="submit" value="Actualizar">
       </form>
    </div>

    <div>
        cursadas
        <table>
            <tr>
                <td>materia</td>
                <td>año</td>
                <td>carrera</td>
                <td>aprobada</td>
            </tr>
            @foreach($alumno->cursadas as $cursada)
                <tr>
                    <td>{{$cursada->asignatura->nombre}}</td>
                    <td>{{$cursada->anio_cursada}}</td>
                    <td>{{$cursada->asignatura->carrera->nombre}}</td>
                    <td>{{$cursada->aprobada}}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection