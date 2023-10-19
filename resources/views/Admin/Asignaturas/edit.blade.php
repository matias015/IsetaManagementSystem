@extends('Admin.template')

@section('content')
<div class="edit-form-container">
    <div>
    <div class="perfil_one table">
       <form method="post" action="{{route('admin.asignaturas.update', ['asignatura'=>$asignatura->id])}}">
        @csrf
        @method('put')

        <span class="perfil_dataname">Asignatura: <input class="campo_info" value="{{$asignatura->nombre}}" name="nombre"></span>
        <span class="perfil_dataname">Carrera: 
            <p class="campo_info">{{$textFormatService->ucfirst($asignatura->carrera->nombre)}}</p>
        </span>
        <span class="perfil_dataname">Tipo modulo: 
            <select class="campo_info" name="tipo_modulo">
                <option @selected($asignatura->tipo_modulo==1) value="1">Modulos</option>
                <option @selected($asignatura->tipo_modulo==2) value="2">Horas</option>
            </select>
        </span>
        <span class="perfil_dataname">Carga horaria: <input class="campo_info" value="{{$asignatura->carga_horaria}}" name="carga_horaria"></span>
        <span class="perfil_dataname">Año:<input class="campo_info" value="{{$asignatura->anio}}" name="anio"></span>
        <span class="perfil_dataname">Observaciones: <input class="campo_info" value="{{$asignatura->observaciones}}" name="observaciones"></span>
        <span class="perfil_dataname">Promocionable: <input @checked($asignatura->promocionable) type="checkbox" name="promocionable"></span>
        <span class="perfil_dataname">Correlativas:
            <ul class="campo_info">
                @foreach ($asignatura->correlativas as $correlativa)
                <form method="post" action="{{route('correlativa.eliminar', ['asignatura'=>$asignatura->id,'asignatura_correlativa'=>$correlativa->asignatura->id])}}">
                    @csrf
                    @method('delete')
                    <li>- {{$textFormatService->ucfirst($correlativa->asignatura->nombre)}}</li>
                    <button class="btn_edit">Eliminar</button>
                </form>
                @endforeach
            </ul>
    </span>
        <div class="upd"><input class="btn_borrar upd" type="submit" value="Actualizar"></div>
        </form>
    </div>


        {{-- -------------------------- --}}

        <div class="perfil_one table">
            <div>
                <h2>Agregar correlativa</h2>
            </div>
            <form method="post" action="{{route('correlativa.agregar', ['asignatura'=>$asignatura->id])}}">
            @csrf

                <span class="perfil_dataname">Materia: 
                    <select class="campo_info" id="asignatura_select" name="id_asignatura">
                    @foreach ($asignatura->carrera->asignaturas as $asignatura_carrera)
                        @if ($asignatura_carrera->id != $asignatura->id)
                            <option value="{{$asignatura_carrera->id}}">{{$textFormatService->ucfirst($asignatura_carrera->nombre)}}</option>
                        @endif
                    @endforeach
               
                    </select>
                </span>
                <div class="upd"><a href=""><button class="btn_edit">Agregar</button></a></div>
            </form>
        </div>
       
    <div class="table">
        <div class="table__header">
            <p>Alumnos que cursan esta materia que aun no tienen un estado final (aprobado o desaprobado)</p>
            <input class="btn_borrar" type="submit" value="Imprimir">
        </div>
       <table>
        <thead>
                <tr>
                <th>imprimir</th>
                <th>nombre</th>
                <th>dni</th>
                <th>Condicion</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <form action="{{route('test.print-1', ['asignatura'=>$asignatura->id])}}">
                
            @foreach ($alumnos as $alumno)
                <tr>
                    <td><input type="checkbox" checked name="toPrint[]" value="{{$alumno->id}}"></td>
                
                    <td> {{$textFormatService->ucwords($alumno->apellido.' '.$alumno->nombre)}}</td>

                    <td> {{$alumno->dni}}</td>
<td>       @switch($alumno->condicion)
    @case(0)
      Libre
      @break
    @case(1)
      Regular  
      @break
    @case(2)
      Promocion  
      @break
    @case(3)
      Equivalencia  
      @break
    @case(4)
      Desertor
      @break
    @default
        Otro
    @endswitch</td>
                    <td style="display:flex;">
                    {{-- <form action="">
                        <button class="btn_edit">Editar</button>
                    </form>
                    <form action="">
                        <button class="btn_edit">Eliminar</button>
                    </form> --}}
                    <a href="{{route('admin.cursadas.edit', ['cursada' => $alumno->cursada_id])}}" class="btn_edit wit">Editar cursada</a>
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
</div>

{{-- <script src="{{asset('js/obtener-materias.js')}}"></script> --}}

@endsection
