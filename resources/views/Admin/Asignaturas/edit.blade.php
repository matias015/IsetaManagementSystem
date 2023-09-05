@extends('Admin.template')

@section('content')
<div class="edit-form-container">
    <div>
    <div class="perfil_one table">
        @if ($errors -> any())
            @foreach ($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif


       <form method="post" action="{{route('admin.asignaturas.update', ['asignatura'=>$asignatura->id])}}">
        @csrf
        @method('put')

        <span class="perfil_dataname">Asignatura: <input class="campo_info" value="{{$asignatura->nombre}}" name="nombre"></span>
        <span class="perfil_dataname">Carrera: 
            <p>{{$asignatura->carrera->nombre}}</p>
        </span>
        <span class="perfil_dataname">Tipo modulo: <input class="campo_info" value="{{$asignatura->tipo_modulo}}" name="tipo_modulo"></span>
        <span class="perfil_dataname">Carga horaria: <input class="campo_info" value="{{$asignatura->carga_horaria}}" name="carga_horaria"></span>
        <span class="perfil_dataname">Año:<input class="campo_info" value="{{$asignatura->anio}}" name="anio"></span>
        <span class="perfil_dataname">Observaciones: <input class="campo_info" value="{{$asignatura->observaciones}}" name="observaciones"></span>

        

        <div class="upd"><input class="btn_borrar upd" type="submit" value="Actualizar"></div>
        </form>
    </div>

    <span class="perfil_dataname">Correlativas:
        <ul class="campo_info">
            @foreach ($asignatura->correlativas as $correlativa)
            <form method="post" action="{{route('correlativa.eliminar', ['asignatura'=>$asignatura->id,'asignatura_correlativa'=>$correlativa->asignatura->id])}}">
                @csrf
                @method('delete')
                <li>- {{$correlativa->asignatura->nombre}}</li>
                <button>Eliminar</button>
            </form>
            @endforeach
        </ul>
    </span>
    
        {{-- -------------------------- --}}
        <h2>Agregar correlativa</h2>

       <form method="post" action="{{route('correlativa.agregar', ['asignatura'=>$asignatura->id])}}">
        @csrf

        <p>
            materia 
            <select id="asignatura_select" name="id_asignatura">
                @foreach ($asignatura->carrera->asignaturas as $asignatura_carrera)
                    @if ($asignatura_carrera->id != $asignatura->id)
                        <option value="{{$asignatura_carrera->id}}">{{$asignatura_carrera->nombre}}</option>
                    @endif
                @endforeach
               
            </select>
        </p>
            <a href=""><button>Agregar</button></a>
        </form>
       
       
       <hr>
       <table>
        <tr>
            <td>imprimir</td>
            <td>nombre</td>
            <td>dni</td>
            <td>acciones</td>
        </tr>

        <form enctype="multipart/form-data" action="{{route('test.print-1')}}">
            alumnos que cursan esta materia que aun no tienen un estado final (aprobado o desaprobado)
        @foreach ($alumnos as $alumno)
            <tr>
                <td><input type="checkbox" checked name="toPrint[]" value="{{$alumno->id}}"></td>
                
                <td> {{$alumno->nombre}} {{$alumno->apellido}}</td>

                <td> {{$alumno->dni}}</td>

                <td style="display:flex;">
                    {{-- <form action="">
                        <button>Editar</button>
                    </form>
                    <form action="">
                        <button>Eliminar</button>
                    </form> --}}
                    <a href="{{route('admin.cursadas.edit', ['cursada' => $alumno->cursada_id])}}">Editar cursada</a>
                </td>
            </tr>
        @endforeach

            

       
       <input type="submit" value="Imprimir">
    </form>
    </table>
    </div>
</div>

{{-- <script src="{{asset('js/obtener-materias.js')}}"></script> --}}

@endsection
