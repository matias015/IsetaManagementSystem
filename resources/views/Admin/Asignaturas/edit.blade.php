@extends('Admin.template')

@section('content')

    <div>

        @if ($errors -> any())
            @foreach ($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif


       <form method="post" action="{{route('admin.asignaturas.update', ['asignatura'=>$asignatura->id])}}">
        @csrf
        @method('put')

        <p>asignatura <input value="{{$asignatura->nombre}}" name="nombre"></p>
        <select name="id_carrera">
            @foreach($carreras as $carrera)
                <option @selected($carrera->id == $asignatura->id_carrera) value="{{$carrera->id}}">{{$carrera->nombre}}</option>
            @endforeach
        </select>
        <p>tipo modulo <input value="{{$asignatura->tipo_modulo}}" name="tipo_modulo"></p>
        <p>carga horaria <input value="{{$asignatura->carga_horaria}}" name="carga_horaria"></p>
        <p>año<input value="{{$asignatura->anio}}" name="anio"></p>
        <p>observaciones <input value="{{$asignatura->observaciones}}" name="observaciones"></p>

        <input type="submit" value="Actualizar">
       </form>
       <hr>
       <table>
        <tr>
            <td>imprimir</td>
            <td>nombre</td>
            <td>apellido</td>
            <td>dni</td>
            <td>acciones</td>
        </tr>

        <form enctype="multipart/form-data" action="{{route('test.print-1')}}">
            alumnos que cursan esta materia que aun no tienen un estado final (aprobado o desaprobado)
        @foreach ($alumnos as $alumno)
            <tr>
                <td><input type="checkbox" checked name="toPrint[]" value="{{$alumno->id}}"></td>
                
                <td> {{$alumno->nombre}} </td>

                <td> {{$alumno->apellido}} </td>

                <td> {{$alumno->dni}} horas</td>

                <td style="display:flex;">
                    {{-- <form action="">
                        <button>Editar</button>
                    </form>
                    <form action="">
                        <button>Eliminar</button>
                    </form> --}}
                    <a href="{{route('admin.cursadas.edit', ['asignatura' => $asignatura->id, 'alumno' => $alumno->id])}}">Editar cursada</a>
                </td>
            </tr>
        @endforeach

            

       </table>
       <input type="submit" value="Imprimir">
    </form>
    </div>


@endsection