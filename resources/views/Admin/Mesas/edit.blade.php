@extends('Admin.template')

@section('content')
    <div>

<div class="edit-form-container">

        <h2>{{$mesa->materia->nombre}}</h2>
       <form method="post" action="{{route('admin.mesas.update', ['mesa'=>$mesa->id])}}">
        @csrf
        @method('put')

        <p>Materia <input value="{{$mesa->fecha}}" name="fecha"></p>
        <p>Llamado <input value="{{$mesa->llamado}}" name="llamado"></p>

        <p>
            Prof. presidente
            <select name="prof_presidente">
                <option @selected($mesa->prof_presidente==0) value="vacio">vacio/A confirmar</option>

                @foreach($profesores as $profesor)
                    <option @selected($mesa->prof_presidente != 0 && $mesa->profesor->id == $profesor->id) value="{{$profesor->id}}">{{$profesor->nombre}}</option>
                @endforeach
            </select>
        </p>
        <p>
            Prof. vocal 1
            <select name="prof_vocal_1">
                <option @selected($mesa->prof_vocal_1==0) value="vacio">vacio/A confirmar</option>

                @foreach($profesores as $profesor)
                    <option @selected($mesa->prof_vocal_1 != 0 && $mesa->vocal1->id == $profesor->id) value="{{$profesor->id}}">{{$profesor->nombre}}</option>
                @endforeach
            </select>
        </p>
        <p>
            Prof. vocal 2
            <select name="prof_vocal_2">
                <option @selected($mesa->prof_vocal_2==0) value="vacio">vacio/A confirmar</option>

                @foreach($profesores as $profesor)
                    <option @selected($mesa->prof_vocal_2 != 0 && $mesa->vocal2 && $mesa->vocal2->id == $profesor->id) value="{{$profesor->id}}">{{$profesor->nombre}}</option>
                @endforeach
            </select>
        </p>

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
            <a href="{{route('admin.mesas.acta',['mesa'=>$mesa->id])}}"><button>Acta volante</button></a>
        </table>
    </div></div>
@endsection