@extends('Admin.template')

@section('content')
    <div class="edit-form-container">
        <div class="perfil_one br">
            <div class="perfil__header">
                <h2>Ficha profesor/a</h2>
            </div>
            <div class="perfil__info">
                <form method="post" action="{{route('admin.profesores.update', ['profesor'=>$profesor->id])}}">
                    @csrf
                    @method('put')

                    <div class="perfil_dataname">
                        <label>DNI:</label>
                        <input class="rounded px-2 campo_info" value="{{$profesor->dni}}" name="dni">
                    </div>
                    <div class="perfil_dataname">
                        <label>Nombre:</label>
                        <input class="rounded px-2 campo_info" value="{{$profesor->nombre}}" name="nombre">
                    </div>
                    <div class="perfil_dataname">
                        <label>Apellido:</label>
                        <input class="rounded px-2 campo_info" value="{{$profesor->apellido}}" name="apellido">
                    </div>
                    <div class="perfil_dataname">
                        <label>Fecha de nacimiento:</label>
                        <input class="rounded px-2 campo_info" value="{{$profesor->fecha_nacimiento->format('Y-m-d')}}" type="date" name="fecha_nacimiento">
                    </div>
                    <div class="perfil_dataname">
                        <label>Ciudad:</label>
                        <input class="rounded px-2 campo_info" value="{{$profesor->ciudad}}" value="9 de Julio" name="ciudad">
                    </div>
                    <div class="perfil_dataname">
                        <label>Calle:</label>
                        <input class="rounded px-2 campo_info" value="{{$profesor->calle}}" name="calle">
                    </div>
                    <div class="perfil_dataname">
                        <label>Numero:</label>
                        <input class="rounded px-2 campo_info" value="{{$profesor->numero}}"  name="casa_numero">
                    </div>
                    <div class="perfil_dataname">
                        <label>Departamento:</label>
                        <input class="rounded px-2 campo_info" value="{{$profesor->departamento}}" name="dpto">
                    </div>
                    <div class="perfil_dataname">
                        <label>Piso:</label>
                        <input class="rounded px-2 campo_info" value="{{$profesor->piso}}" name="piso">
                    </div>
                    <div class="perfil_dataname">
                        <label>Estado civil: </label>
                        <select class="rounded px-2 campo_info" name="estado_civil">
                            <option @if($profesor->estado_civil==0) selected @endif value="0">soltero</option>
                            <option @if($profesor->estado_civil==1) selected @endif value="1">casado</option>
                        </select>
                    </div>
                    <div class="perfil_dataname">
                        <label>Email:</label>
                        <input class="rounded px-2 campo_info" value="{{$profesor->email}}" name="email">
                    </div>
                    <div class="perfil_dataname">
                        <label>Formacion academica:</label>
                        <input class="rounded px-2 campo_info" value="{{$profesor->formacion_academica}}" name="formacion_academica">
                    </div>
                    <div class="perfil_dataname">
                        <label>Año de ingreso:</label>
                        <input class="rounded px-2 campo_info" value="{{$profesor->anio_ingreso}}" name="anio_ingreso">
                    </div>
                    <div class="perfil_dataname">
                        <label>Observaciones:</label>
                        <textarea value="{{$profesor->observaciones}}" name="observaciones" rows="10"></textarea>
                    </div>
                    <div class="perfil_dataname">
                        <label>Telefono:</label>
                        <input class="rounded px-2 campo_info" value="{{$profesor->telefono1}}" name="telefono1">
                    </div>
                    <div class="perfil_dataname">
                        <label>Telefono 2:</label>
                        <input class="rounded px-2 campo_info" value="{{$profesor->telefono2}}" name="telefono2">
                    </div>
                    <div class="perfil_dataname">
                        <label>Telefono 3:</label>
                        <input class="rounded px-2 campo_info" value="{{$profesor->telefono3}}" name="telefono3">
                    </div>
                    <div class="perfil_dataname">
                        <label>Codigo postal:</label>
                        <input class="rounded px-2 campo_info" value="{{$profesor->codigo_postal}}" value="6500" name="codigo_postal">
                    </div>

                    <div class="upd"><input class="btn_borrar upd" type="submit" value="Actualizar"></div>
                </form>
            </div>
        </div>

        <div class="table">
            <div  class="table__header"><h2>Proximas mesas</h2></div>
            <table class="table__body">
                <thead>
                    <tr>
                        <th>Asignatura</th>
                        <th>Fecha</th>
                        <th>Rol</th>
                        <th class="center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($mesas as $mesa)
                    <tr>
                        <td>{{$mesa->asignatura->nombre}}</td>
                        <td>{{$formatoFecha->dmhm($mesa->fecha)}}</td>
                        <td>
                            @if ($mesa->prof_presidente == $profesor->id)
                                Presidente
                            @elseif ($mesa->prof_vocal_1 == $profesor->id)
                                Vocal 1
                            @elseif ($mesa->prof_vocal_2 == $profesor->id)
                                Vocal 2
                            @endif
                        </td>
                        <td class="flex just-center"><a href="{{route('admin.mesas.edit',['mesa'=>$mesa->id])}}"><button class="btn_blue"><i class="ti ti-file-info"></i>Detalles</button></a></td>
                    </tr>
                    @endforeach
                </tbody>           
            </table>

        </div>   
    
    </div>
@endsection
