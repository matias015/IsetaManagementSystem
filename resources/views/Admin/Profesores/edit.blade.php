@extends('Admin.template')

@section('content')
    <div>
        @if ($errors -> any())
            @foreach ($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif

        <div class="edit-form-container">
            <h1>Ficha profesor/a</h1>
            <div class="perfil_one table">
                <form method="post" action="{{route('admin.profesores.update', ['profesor'=>$profesor->id])}}">
                    @csrf
                    @method('put')

                    <span class=" perfil_dataname sep1">DNI: <input class="rounded px-2 campo_info" value="{{$profesor->dni}}" name="dni"></span>
                    <span class="perfil_dataname">Nombre: <input class="rounded px-2 campo_info" value="{{$profesor->nombre}}" name="nombre"></span>
                    <span class="perfil_dataname">Apellido: <input class="rounded px-2 campo_info" value="{{$profesor->apellido}}" name="apellido"></span>
                    <span class="perfil_dataname">Fecha nacimiento: <input class="rounded px-2 campo_info" value="{{$profesor->fecha_nacimiento->format('Y-m-d')}}" type="date" name="fecha_nacimiento"></span>
                    <span class="perfil_dataname">Ciudad: <input class="rounded px-2 campo_info" value="{{$profesor->ciudad}}" value="9 de Julio" name="ciudad"></span>
                    <span class="perfil_dataname">Calle: <input class="rounded px-2 campo_info" value="{{$profesor->calle}}" name="calle"></span>
                    <span class="perfil_dataname">Numero: <input class="rounded px-2 campo_info" value="{{$profesor->numero}}"  name="casa_numero"></span>
                    <span class="perfil_dataname">Departamento: <input class="rounded px-2 campo_info" value="{{$profesor->departamento}}" name="dpto"></span>
                    <span class="perfil_dataname">Piso: <input class="rounded px-2 campo_info" value="{{$profesor->piso}}" name="piso"></span>
                    <span class="perfil_dataname">Estado civil: 
                        <select class="rounded px-2 campo_info" name="estado_civil">
                            <option @if($profesor->estado_civil==0) selected @endif value="0">soltero</option>
                            <option @if($profesor->estado_civil==1) selected @endif value="1">casado</option>
                        </select>
                    </span>
                    <span class="perfil_dataname">Email: <input class="rounded px-2 campo_info" value="{{$profesor->email}}" name="email"></span>
                    <span class="perfil_dataname">Formacion academica: <input class="rounded px-2 campo_info" value="{{$profesor->formacion_academica}}" name="formacion_academica"></span>
                    <span class="perfil_dataname">Año de ingreso: <input class="rounded px-2 campo_info" value="{{$profesor->anio_ingreso}}" name="anio_ingreso"></span>
        
                    <span class="perfil_dataname">Observaciones: <textarea value="{{$profesor->observaciones}}" name="observaciones" rows="10"></textarea></span>

                    <span class="perfil_dataname">Telefono: <input class="rounded px-2 campo_info" value="{{$profesor->telefono1}}" name="telefono1"></span>
                    <span class="perfil_dataname">Telefono 2: <input class="rounded px-2 campo_info" value="{{$profesor->telefono2}}" name="telefono2"></span>
                    <span class="perfil_dataname">Telefono 3:<input class="rounded px-2 campo_info" value="{{$profesor->telefono3}}" name="telefono3"></span>
                    <span class="perfil_dataname">Codigo postal:<input class="rounded px-2 campo_info" value="{{$profesor->codigo_postal}}" value="6500" name="codigo_postal"></span>

                    <div class="upd"><input class="btn_borrar upd" type="submit" value="Actualizar"></div>
                </form>
            </div>

        <div class="table">
            <div  class="table__header"><h2>Proximas mesas</h2></div>
            <table>
                <thead>
                    <tr>
                        <th>Asignatura</th>
                        <th>Fecha</th>
                        <th>Rol</th>
                        <th>Detalles</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($mesas as $mesa)
                    <tr>
                        <td>{{$mesa->materia->nombre}}</td>
                        <td>{{$mesa->fecha}}</td>
                        <td>
                            @if ($mesa->prof_presidente == $profesor->id)
                                Presidente
                            @elseif ($mesa->prof_vocal_1 == $profesor->id)
                                Vocal 1
                            @elseif ($mesa->prof_vocal_2 == $profesor->id)
                                Vocal 2
                            @endif
                        </td>
                        <td><a href="{{route('admin.mesas.edit',['mesa'=>$mesa->id])}}">Detalles</a></td>
                    </tr>
                    @endforeach
                </tbody>           
            </table>

        </div>

        </div>     
    
    </div>
@endsection
