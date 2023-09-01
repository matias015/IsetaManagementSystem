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
            <select class="campo_info" name="id_carrera">
                @foreach($carreras as $carrera)
                    <option @selected($carrera->id == $asignatura->id_carrera) value="{{$carrera->id}}">{{$carrera->nombre}}</option>
                @endforeach
            </select>
        </span>
        <span class="perfil_dataname">Tipo modulo: <input class="campo_info" value="{{$asignatura->tipo_modulo}}" name="tipo_modulo"></span>
        <span class="perfil_dataname">Carga horaria: <input class="campo_info" value="{{$asignatura->carga_horaria}}" name="carga_horaria"></span>
        <span class="perfil_dataname">Año:<input class="campo_info" value="{{$asignatura->anio}}" name="anio"></span>
        <span class="perfil_dataname">Observaciones: <input class="campo_info" value="{{$asignatura->observaciones}}" name="observaciones"></span>

        <span class="perfil_dataname">Correlativas:
            <ul class="campo_info">
            @foreach ($asignatura->correlativas as $correlativa)
                <li>- {{$correlativa->asignatura->nombre}}</li>
            @endforeach
        </ul></span>
        <ul>
            @foreach ($asignatura->correlativas as $correlativa)
                <li>- {{$correlativa->asignatura->nombre}}</li>
            @endforeach
        </ul>

        <div class="upd"><input class="btn_borrar upd" type="submit" value="Actualizar"></div>
        </form>
    </div>

        {{-- -------------------------- --}}
        <h2>Agregar correlativa</h2>
        
        <select name="carrera" id="carrera_select">
            @foreach ($carreras as $carrera)
                <option value="{{$carrera->id}}">{{$carrera->nombre}}</option>
            @endforeach
        </select>

       <form method="post" action="">
        @csrf

        <p>
            materia 
            <select id="asignatura_select" name="id_asignatura">
                <option value="">selecciona una carrera</option>
            </select>
        </p>
            <a href=""><button>Agregar</button></a>
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
                    <a href="{{route('admin.cursadas.edit', ['cursada' => $alumno->cursada_id])}}">Editar cursada</a>
                </td>
            </tr>
        @endforeach

            

       
       <input type="submit" value="Imprimir">
    </form>
    </table>
    </div>
</div>

<script src="{{asset('js/obtener-materias.js')}}"></script>

@endsection
