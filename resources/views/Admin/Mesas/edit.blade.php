@extends('Admin.template')

@section('content')
    <div>
        @if ($errors -> any())
            @foreach ($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif
<div class="edit-form-container">

        <h2>{{$mesa->materia->nombre}}</h2>
       <form method="post" action="{{route('admin.mesas.update', ['mesa'=>$mesa->id])}}">
        @csrf
        @method('put')

        <p>Materia <input value="{{$mesa->fecha}}" name="fecha"></p>
        <p>Llamado <input value="{{$mesa->llamado}}" name="llamado"></p>
        
        <input type="submit" value="Actualizar">
       </form>
    </div>

    <div>
        <h2>Alumnos inscriptos</h2>
        <p>Agregar alumno</p>
        <p>

        @if(strtotime($mesa->fecha) > time())
        
            estos alumnos han aprobado la cursada de esta materia, luego se volvera a validar sobre equivalencias y tiempos
            
            <form method="POST" action="{{route('admin.examenes.store')}}">
                @csrf
                
            <select name="id_alumno">
                <option value=""></option>
                @foreach ($inscribibles as $inscribible)
                    <option value="{{$inscribible->id}}">{{$inscribible->nombre.' '.$inscribible->apellido}}</option>
                @endforeach
                
            </select>
            <input name="id_mesa" value="{{$mesa->id}}" type="hidden">
          <input type="submit" value="Agregar">
            </form>
        @else
            Ya no se pueden agregar alumnos    
        @endif
    </p>
        <table>
            <tr>
                <td>nombre</td>
                <td>apellido</td>
                <td>nota</td>
                <td>cosas</td>
            </tr>
            @foreach($alumnos as $alumno)
                <tr>
                    <td>{{$alumno->nombre}}</td>
                    <td>{{$alumno->apellido}}</td>
                    <td>{{$alumno->nota}}</td>
                    <td>
                        <form method="POST" action="{{route('admin.examenes.destroy', ['examen' => $alumno->id_examen])}}">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="Eliminar">
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div></div>
@endsection