@extends('Admin.template')

@section('content')
    <div>



       <form method="post" action="{{route('admin.alumnos.store')}}">
        @csrf
        <p>dni <input value="{{old('dni')}}" name="dni"></p>
        <p>nombre <input name="nombre"></p>
        <p>apellido <input name="apellido"></p>
        <p>fecha nacimiento <input type="date" name="fecha_nacimiento"></p>
        <p>ciudad <input value="9 de Julio" name="ciudad"></p>
        <p>calle <input name="calle"></p>
        <p>numero <input  name="casa_numero"></p>
        <p>departamento <input name="dpto"></p>
        <p>piso <input name="piso"></p>
        <p>
            estado civil 
            <select name="estado_civil">
                <option selected value="0">soltero</option>
                <option value="1">casado</option>
            </select>
        </p>
        <p>email <input value="@gmail.com" name="email"></p>
        <p>titulo anterior <input name="titulo_anterior"></p>
        <p>becas <input name="becas"></p>
        
        <p>observaciones <textarea name="observaciones" cols="30" rows="10"></textarea></p>

        <p>telefono <input value="2317" name="telefono1"></p>
        <p>telefono 2 <input name="telefono2"></p>
        <p>telefono 3<input name="telefono3"></p>
        <p>codigo postal<input value="6500" name="codigo_postal"></p>

        <input type="submit" value="Crear">
       </form>
    </div>
@endsection