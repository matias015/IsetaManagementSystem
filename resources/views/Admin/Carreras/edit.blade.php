@extends('Admin.template')

@section('content')
    <div>


        <div class="edit-form-container">
            <div class="perfil_one table">
            <form method="post" action="{{route('admin.carreras.update', ['carrera'=>$carrera->id])}}">
                @csrf
                @method('put')

                    <span class="perfil_dataname">Carrera: <input class="campo_info" value="{{$carrera->nombre}}" name="nombre"></span>
                    <span class="perfil_dataname">Resolucion: <input class="campo_info" value="{{$carrera->resolucion}}" name="resolucion"></span>
                    <span class="perfil_dataname">Año apertura: <input class="campo_info" value="{{$carrera->anio_apertura}}" name="anio_apertura"></span>
                    <span class="perfil_dataname">Año fin: <input class="campo_info" value="{{$carrera->anio_fin}}" name="anio_fin"></span>
                    <span class="perfil_dataname">Observaciones: <input class="campo_info" value="{{$carrera->observaciones}}" name="observaciones"></span>

                    <div class="upd"><input class="btn_borrar upd" type="submit" value="Actualizar"></div>
            </form>
            </div>
            
            <div class="table">
                <div  class="table__header">
                <a href="{{route('admin.asignaturas.create',['id_carrera'=>$carrera->id])}}"><button class="btn_edit">Agregar asignatura</button></a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Año</th>
                            <th>Materia</th>
                            <th>Carga anual o semanal</th>
                            <th colspan="2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($carrera->asignaturas as $asignatura)
                            <tr>
                                <td> {{$asignatura->anio + 1}} </td>

                                <td> {{$asignatura->nombre}} </td>

                                <td> {{$asignatura->carga_horaria}} horas</td>

                                <td style="display:flex;">
                                    <form action="{{route('admin.asignaturas.edit', ['asignatura'=>$asignatura->id])}}">
                                        <button class="btn_edit">Editar</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{route('admin.asignaturas.destroy', ['asignatura'=>$asignatura->id])}}">
                                        <button class="btn_edit">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table> 
            </div>
            
        </div>
    </div>

@endsection
