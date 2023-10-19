@extends('Admin.template')

@section('content')
<div class="edit-form-container">
    <h1>Historia academica</h1>
    <div class="perfil_one table">
            
        <form class="" method="post" action="{{route('admin.alumnos.update', ['alumno'=>$alumno->id])}}">
        @csrf
        @method('put')
        
        <span class="perfil_dataname sep1">DNI: <input class="px-2 rounded campo_info" value="{{old('dni')? old('dni'):$alumno->dni}}" name="dni"></span>
        <span class="perfil_dataname">Nombre: <input class="px-2 rounded campo_info" value="{{old('nombre')? old('nombre'):$alumno->nombre}}" name="nombre"></span>
        <span class="perfil_dataname">Apellido: <input class="px-2 rounded campo_info" value="{{old('apellido')? old('apellido'):$alumno->apellido}}" name="apellido"></span>
        <span class="perfil_dataname">Fecha nacimiento: <input class="px-2 rounded campo_info" value="{{old('fecha_nacimiento')? old('fecha_nacimiento'):$alumno->fecha_nacimiento->format('Y-m-d')}}" type="date" name="fecha_nacimiento"></span>
        <span class="perfil_dataname">Ciudad: <input class="px-2 rounded campo_info" value="{{old('ciudad')? old('ciudad'):$alumno->ciudad}}" name="ciudad"></span>
        <span class="perfil_dataname">Calle: <input class="px-2 rounded campo_info" value="{{old('calle')? old('calle'):$alumno->calle}}" name="calle"></span>
        <span class="perfil_dataname">Numero: <input class="px-2 rounded campo_info" value="{{old('casa_numero')? old('casa_numero'):$alumno->numero}}"  name="casa_numero"></span>
        <span class="perfil_dataname">Departamento: <input class="px-2 rounded campo_info" value="{{old('dpto')? old('dpto'):$alumno->departamento}}" name="dpto"></span>
        <span class="perfil_dataname">Piso: <input class="px-2 rounded campo_info" value="{{old('piso')? old('piso'):$alumno->piso}}" name="piso"></span>
        <span class="perfil_dataname">
            Estado civil: 
            <select class="px-2 rounded campo_info" name="estado_civil">
                <option @if($alumno->estado_civil==0) selected @endif value="0">soltero</option>
                <option @if($alumno->estado_civil==1) selected @endif value="1">casado</option>
            </select>
        </span>
        <span class="perfil_dataname">Email: <input class="px-2 rounded campo_info" value="{{old('email')? old('email'):$alumno->email}}" name="email"></span>
        <span class="perfil_dataname">Titulo anterior: <input class="px-2 rounded campo_info" value="{{old('titulo_anterior')? old('titulo_anterior'):$alumno->titulo_anterior}}" name="titulo_anterior"></span>
        <span class="perfil_dataname">Becas: <input class="px-2 rounded campo_info" value="{{old('becas')? old('becas'):$alumno->becas}}" name="becas"></span>
        
        <span class="perfil_dataname w-100p">Observaciones: <textarea value="{{old('observaciones')? old('observaciones'):$alumno->observaciones}}" name="observaciones" rows="10"></textarea></span>

        <span class="perfil_dataname">Telefono: <input class="px-2 rounded campo_info" value="{{old('telefono1')? old('telefono1'):$alumno->telefono1}}" name="telefono1"></span>
        <span class="perfil_dataname">Telefono 2: <input class="px-2 rounded campo_info" value="{{old('telefono2')? old('telefono2'):$alumno->telefono2}}" name="telefono2"></span>
        <span class="perfil_dataname">Telefono 3:<input class="px-2 rounded campo_info" value="{{old('telefono3')? old('telefono3'):$alumno->telefono3}}" name="telefono3"></span>
        <span class="perfil_dataname">Codigo postal:<input class="px-2 rounded campo_info" value="{{old('codigo_postal')? old('codigo_postal'):$alumno->codigo_postal}}" value="6500" name="codigo_postal"></span>

        <div class="upd"><input class="btn_borrar upd" type="submit" value="Actualizar"></div>
        
       </form>
    </div>

    <br><br>
    

    <form action="{{route('admin.alumno.rematricular',['alumno' => $alumno->id])}}">
        <select name="carrera" id="">
            @foreach ($carreras as $carrera)
                <option value="{{$carrera->id}}">{{$textFormatService->ucfirst($carrera->nombre)}}</option>
            @endforeach
        </select>
        <button>Matricular</button>
    </form>
    <br><br><br>

    <div class="table">
        <div  class="table__header">
        <h2>Cursadas</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Materia</th>
                    {{-- <th>Año</th> --}}
                    {{-- <th>Carrera</th> --}}
                    <th>Condicion</th>
                    <th>Aprobada</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody>

            @php
                $carrera_actual = "";
                $anio_actual = "";
            @endphp

            @foreach($cursadas as $cursada)

                {{-- @dd($cursada) --}}
                @if ($carrera_actual != $cursada->carrera)
                    <tr>
                        <td class="center font-600" colspan=4>{{$cursada->carrera}}</td>
                    </tr>
                    @php  
                        $carrera_actual = $cursada->carrera;
                        $anio_actual = "";
                    @endphp
                @endif
  

                @if ($anio_actual != $cursada->anio_asig)
                    <tr>
                        <td class="center font-600" colspan=4>
                            Año: {{$cursada->anio_asig+1}}
                        </td>
                    </tr>
                    @php
                            $anio_actual = $cursada->anio_asig
                    @endphp
                @endif
  

                <tr>
                    <td>{{$textFormatService->ucfirst($cursada->asignatura)}}</td>
                    {{-- <td>{{$cursada->anio_cursada}}</td> --}}
                    {{-- <td>
                        {{$textFormatService->ucfirst($cursada->carrera)}}
                    </td> --}}
                    <td>
                        @switch($cursada->condicion)
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
                    @endswitch
                    </td>
                    <td>
                        @if ($cursada->aprobada==1)
                            Si
                        @elseif($cursada->aprobada==2)
                            No
                        @else
                            Cursando
                        @endif
                    </td>
                    <td>
                        
                        <a href="{{route('admin.cursadas.edit', ['cursada' => $cursada->id,])}}">
                            <button class="btn_edit">Editar</button>
                        </a>
    
                        
                    </td>
                    <td>
                    <form method="POST" action="{{route('admin.cursadas.destroy', ['cursada' => $cursada->id])}}">
                            @method('delete')
                            @csrf
                            <button class="btn_borrar">Eliminar</button>
                        </form>
                    </td>
                
                </tr>
                    
                    
            @endforeach
            </tbody>
        </table>
        
        
    </div> 
    <br><br><br>

    <div class="table">
        <div class="table__header">
            <h2>Examenes</h2>
            <p>Importante: algunos examanes de alumnos mas antiguos podrian no tener datos sobre las mesas.
            </p>
        </div>
            <table>
                <thead>
                    <tr>
                        <th>Materia</th>
                        {{-- <th>Carrera</th> --}}
                        <th>Nota</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php  
                        $carrera_actual = "";
                        $anio_actual = "";
                    @endphp

                    @foreach($examenes as $examen)

                        @if ($carrera_actual != $examen->carrera)
                            <tr>
                                <td class="center font-600" colspan=4>{{$examen->carrera}}</td>
                            </tr>
                            @php  
                                $carrera_actual = $examen->carrera;
                                $anio_actual = "";
                            @endphp
                        @endif
    

                        @if ($anio_actual != $examen->anio_asig)
                            <tr>
                                <td class="center font-600" colspan=4>
                                    Año: {{$examen->anio_asig+1}}
                                </td>
                            </tr>
                            @php
                                    $anio_actual = $examen->anio_asig
                            @endphp
                        @endif

                        <tr>
                            <td>{{$textFormatService->ucfirst($examen->asignatura)}}</td>
                            {{-- <td>{{$textFormatService->ucfirst($examen->carrera)}}</td> --}}
                            <td>
                        
                            @if ($examen->aprobado==3)
                                Ausente
                            @elseif($examen->nota<=0)
                                Sin nota
                            @else
                                {{$examen->nota}}
                            @endif
                            </td>
                            <td><a href="{{route('admin.examenes.edit', ['examen' => $examen->id,])}}"><button class="btn_edit">Editar</button></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
       
    </div> 
    
</div>

@endsection
