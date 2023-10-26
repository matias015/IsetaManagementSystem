@extends('Admin.template')

@section('content')
<div class="edit-form-container">
    <div class="perfil_one br">
        <div class="perfil__header">
            <h2>Asignatura</h2>
        </div>
        <div class="perfil__info">
            <form method="post" action="{{route('admin.asignaturas.update', ['asignatura'=>$asignatura->id])}}">
            @csrf
            @method('put')

                <div class="perfil_dataname">
                    <label>Asignatura:</label>
                    <input class="campo_info rounded" value="{{$asignatura->nombre}}" name="nombre">
                </div>
                <div class="perfil_dataname">
                    <label>Carrera:</label>
                    <span class="campo_info2">{{$asignatura->carrera->nombre}}</span>
                </div>
                <div class="perfil_dataname">
                    <label>Tipo modulo:</label>
                    <select class="campo_info rounded" name="tipo_modulo">
                        <option @selected($asignatura->tipo_modulo==1) value="1">Modulos</option>
                        <option @selected($asignatura->tipo_modulo==2) value="2">Horas</option>
                    </select>
                </div>
                <div class="perfil_dataname">
                    <label>Carga horaria:</label> 
                    <input class="campo_info rounded" value="{{$asignatura->carga_horaria}}" name="carga_horaria">
                </div>
                <div class="perfil_dataname">
                    <label>Año:</label>
                    <input class="campo_info rounded" value="{{$asignatura->anio}}" name="anio">
                </div>
                <div class="perfil_dataname">
                    <label>Observaciones:</label>
                    <input class="campo_info rounded" value="{{$asignatura->observaciones}}" name="observaciones">
                </div>
                <div class="perfil_dataname">
                    <label>Promocionable:</label>
                    <input class="campo_info3" @checked($asignatura->promocionable) type="checkbox" name="promocionable">
                </div>
                <div class="perfil_dataname">
                    <label>Correlativas:</label>
                    <ul class="campo_info rounded">
                        @foreach ($asignatura->correlativas as $correlativa)
                        <form method="post" action="{{route('correlativa.eliminar', ['asignatura'=>$asignatura->id,'asignatura_correlativa'=>$correlativa->asignatura->id])}}">
                            <div class="flex">
                            @csrf
                            @method('delete')
                                <div class="flex items-center"><li>- {{$correlativa->asignatura->nombre}}</li></div>
                                <div class="flex items-center m-1 mx-4"><button class="btn_edit">Eliminar</button></div>
                            </div>
                        </form>
                        @endforeach
                    </ul>
                </div>
                <div class="upd"><input class="btn_borrar upd" type="submit" value="Actualizar"></div>
            </form>
        </div>
    </div>


        {{-- -------------------------- --}}

        <div class="perfil_one br">
            <div class="perfil__header">
                <h2>Agregar correlativa</h2>
            </div>
            <div class="matricular">
                <form method="post" action="{{route('correlativa.agregar', ['asignatura'=>$asignatura->id])}}">
                @csrf

                    <div class="perfil_dataname1">
                        <label>Materia:</label>
                        <select class="campo_info rounded" id="asignatura_select" name="id_asignatura">
                            @foreach ($asignatura->carrera->asignaturas as $asignatura_carrera)
                                @if ($asignatura_carrera->id != $asignatura->id)
                                    <option value="{{$asignatura_carrera->id}}">{{$asignatura_carrera->nombre}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="upd"><a href=""><button class="btn_edit">Agregar</button></a></div>
                </form>
            </div>
        </div>
       
    <div class="table">
        <div class="table__header">
            <p>Alumnos que cursan esta materia que aun no tienen un estado final (aprobado o desaprobado)</p>
            <input class="btn_borrar-alt" type="submit" value="Imprimir">
        </div>
        <table class="table__body">
        <thead>
                <tr>
                <th class="center">Imprimir</th>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Condicion</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <form action="{{route('test.print-1', ['asignatura'=>$asignatura->id])}}">
                
            @foreach ($asignatura->cursadas as $cursada)
                <tr>
                    <td> {{$cursada->alumno->apellidoNombre()}}</td>
                    <td> {{$cursada->alumno->dni}} </td>
                    <td> {{$cursada->condicionString()}} </td>
                    <td>
                        <a href="{{route('admin.cursadas.edit', ['cursada' => $cursada->id])}}" class="btn_edit">Editar</a>
                    </td>
                </tr>
            @endforeach

            </form>
        </tbody>
    </table>
    </div>
    </div>

    <form method="POST" action="{{route('admin.asignaturas.destroy', ['asignatura'=>$asignatura->id])}}">
        @csrf
        @method('delete')
        <button class="btn_edit">Eliminar</button>
    </form>
    
    <br>
    <a class="blue-700 underline" href="/admin/cursantes/{{$asignatura->id}}">Exportar cursadas</a>
</div>



{{-- <script src="{{asset('js/obtener-materias.js')}}"></script> --}}

@endsection
