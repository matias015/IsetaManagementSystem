@extends('Admin.template')

@section('content')
    <div class="edit-form-container">
        <div class="perfil_one br">
            <div class="perfil__header">
                <h2>Carrera</h2>
            </div>
            <div class="perfil__info">

                <form method="post" enctype="multipart/form-data" action="{{route('admin.carreras.update', ['carrera'=>$carrera->id])}}">
                    @csrf
                    @method('put')

                    <div class="perfil_dataname">
                        <label>Carrera:</label>
                        <input class="campo_info rounded" value="{{$carrera->nombre}}" name="nombre">
                    </div>
                    <div class="perfil_dataname">
                        <label>Año apertura:</label>
                        <input class="campo_info rounded" value="{{$carrera->anio_apertura}}" name="anio_apertura">
                    </div>
                    <div class="perfil_dataname">
                        <label>Año fin:</label>
                        <input class="campo_info rounded" value="{{$carrera->anio_fin}}" name="anio_fin">
                    </div>
                    <div class="perfil_dataname">
                        <label>Observaciones:</label>
                        <input class="campo_info rounded" value="{{$carrera->observaciones}}" name="observaciones">
                    </div>
                    <div class="perfil_dataname">
                        <label>Vigente:</label> 
                        <input class="campo_info3 rounded" value="1" type="checkbox"  @checked($carrera->vigente == 1) name="vigente">
                    </div>
                    <div class="flex-col items-start perfil_dataname">
                        <div class="flex">                       
                            <label>Resolucion:</label>
                            <input class="campo_info rounded" value="{{$carrera->resolucion}}" name="resolucion">
                        </div>
                        
                        <input class="campo_info3 rounded" value="1" type="file" name="resolucion_archivo">
                        
                        @if ($carrera->resolucion_archivo)  
                            <span class="font-3 font-400">{{$carrera->resolucion_archivo}}</span>
                            <div class="flex gap-4">
                                    <a class="font-3 blue-700" href="{{route('admin.carreras.resolucion', ['carrera'=>$carrera->id])}}">Descargar resolucion</a>
                                    <a class="font-3 red-600" href="{{route('admin.carreras.resolucion.borrar', ['carrera'=>$carrera->id])}}">Eliminar esta resolucion</a>
                                </div>
                        @endif
                    </div>

                    

           

                    <div class="upd"><button class="btn_blue"><i class="ti ti-refresh"></i>Actualizar</button></div>
                </form>
            </div>
        </div>
    

            <div class="table">
                <div  class="perfil__header-alt">
                <a href="{{route('admin.asignaturas.create',['id_carrera'=>$carrera->id])}}"><button class="btn_blue"><i class="ti ti-circle-plus"></i>Agregar asignatura</button></a>
                <a href="/admin/cursantes/carrera/{{$carrera->id}}"><button class="btn_blue"><i class="ti ti-file-download"></i>Exportar cursadas</button></a>
            </div>
                <table class="table__body">
                    <thead>
                        <tr>
                            <th class="center">Año</th>
                            <th>Materia</th>
                            <th class="center">Carga anual/semanal</th>
                            <th class="center">Acción</th>
                            <th class="center" colspan="2">Crear</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($carrera->asignaturas as $asignatura)
                            <tr>
                                <td class="center"> {{$asignatura->anio}} </td>

                                <td> {{$asignatura->nombre}} </td>

                                <td class="center"> {{$asignatura->carga_horaria}} horas</td>

                                <td style="display:flex;">
                                    <form action="{{route('admin.asignaturas.edit', ['asignatura'=>$asignatura->id])}}">
                                        <button class="btn_blue"><i class="ti ti-edit"></i>Editar</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{route('admin.mesas.create')}}">
                                        <input name="carrera" type="hidden" value="{{$carrera->id}}">
                                        <input name="asignatura" type="hidden" value="{{$asignatura->id}}">
                                        <button class="btn_blue"><i class="ti ti-circle-plus"></i>Mesa</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{route('admin.mesas.dual', ['asignatura'=>$asignatura->id])}}"><button class="btn_blue"><i class="ti ti-circle-plus"></i>Mesas</button></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table> 
            </div>
        @if (!$config['modo_seguro'])       
            <div class="upd">
                <form method="POST" class="form-eliminar" action="{{route('admin.carreras.destroy', ['carrera' => $carrera->id])}}">
                    @csrf
                    @method('delete')
                    <button class="btn_red"><i class="ti ti-trash"></i>Eliminar carrera</button>
                </form>
            </div>
        @endif
    </div>
@endsection
