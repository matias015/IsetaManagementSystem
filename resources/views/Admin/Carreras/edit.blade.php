@extends('Admin.template')

@section('content')
    <div class="edit-form-container">
        <div class="perfil_one br">
            <div class="perfil__header">
                <h2>Carrera</h2>
            </div>
            <div class="perfil__info">

                <form method="post" action="{{route('admin.carreras.update', ['carrera'=>$carrera->id])}}">
                    @csrf
                    @method('put')

                    <div class="perfil_dataname">
                        <label>Carrera:</label>
                        <input class="campo_info rounded" value="{{$carrera->nombre}}" name="nombre">
                    </div>
                    <div class="perfil_dataname">
                        <label>Resolucion:</label>
                        <input class="campo_info rounded" value="{{$carrera->resolucion}}" name="resolucion">
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

                    <div class="upd"><input class="btn_borrar upd" type="submit" value="Actualizar"></div>
                </form>
            </div>
        </div>
            
            <div class="table">
                <div  class="table__header">
                <a href="{{route('admin.asignaturas.create',['id_carrera'=>$carrera->id])}}"><button class="btn_edit wit">Agregar asignatura</button></a>
                <a class="underline" href="/admin/cursantes/carrera/{{$carrera->id}}">Exportar cursadas</a>
    
            </div>
                <table class="table__body">
                    <thead>
                        <tr>
                            <th class="center">Año</th>
                            <th>Materia</th>
                            <th class="center">Carga anual/semanal</th>
                            <th colspan="2">Acciones</th>
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
                                        <button class="btn_edit">Editar</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{route('admin.mesas.create')}}">
                                        <input name="carrera" type="hidden" value="{{$carrera->id}}">
                                        <input name="asignatura" type="hidden" value="{{$asignatura->id}}">
                                        <button class="blue-700 bg-transparent font-5">Crear mesa</button>
                                    </form>
                                    <a href="{{route('admin.mesas.dual', ['asignatura'=>$asignatura->id])}}" class="blue-700 bg-transparent">Crear mesas</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table> 
            </div>
            <td>
                <form method="POST" action="{{route('admin.carreras.destroy', ['carrera' => $carrera->id])}}">
                    @csrf
                    @method('delete')
                    <input class="pointer p-2 bg-red-600 border-none rounded font-600" type="submit" value="Eliminar carrera">
                </form>
            </td>
    </div>
    

@endsection
