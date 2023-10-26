@extends('Admin.template')

@section('content')
<div class="edit-form-container">
    
    <div class="perfil_one br">
        <div class="perfil__header">
            <h2>Historia academica</h2>
        </div>
        <div class="perfil__info">
        <form method="post" action="{{route('admin.alumnos.update', ['alumno'=>$alumno->id])}}">
        @csrf
        @method('put')
            <div class="perfil_dataname sep1">
                <label>DNI:</label>
                <input class="px-2 rounded campo_info" value="{{old('dni')? old('dni'):$alumno->dni}}" name="dni">
            </div>
            <div class="perfil_dataname">
                <label>Nombre: </label>
                <input class="px-2 rounded campo_info" value="{{old('nombre')? old('nombre'):$alumno->nombre}}" name="nombre">
            </div>
            <div class="perfil_dataname">
                <label>Apellido:</label>
                <input class="px-2 rounded campo_info" value="{{old('apellido')? old('apellido'):$alumno->apellido}}" name="apellido">
            </div>
            <div class="perfil_dataname">
                <label>Fecha de nacimiento: </label>
                <input class="px-2 rounded campo_info" value="{{old('fecha_nacimiento')? old('fecha_nacimiento'):$alumno->fecha_nacimiento->format('Y-m-d')}}" type="date" name="fecha_nacimiento">
            </div>
            <div class="perfil_dataname">
                <label >Ciudad:</label>
                <input class="px-2 rounded campo_info" value="{{old('ciudad')? old('ciudad'):$alumno->ciudad}}" name="ciudad">
            </div>
            <div class="perfil_dataname">
                <label >Calle:</label>
                <input class="px-2 rounded campo_info" value="{{old('calle')? old('calle'):$alumno->calle}}" name="calle">
            </div>
            <div class="perfil_dataname">
                <label >Numero:</label>
                <input class="px-2 rounded campo_info" value="{{old('casa_numero')? old('casa_numero'):$alumno->numero}}"  name="casa_numero">
            </div>
            <div class="perfil_dataname">
                <label >Departamento:</label>
                <input class="px-2 rounded campo_info" value="{{old('dpto')? old('dpto'):$alumno->departamento}}" name="dpto">
            </div>
            <div class="perfil_dataname">
                <label >Piso:</label>
                <input class="px-2 rounded campo_info" value="{{old('piso')? old('piso'):$alumno->piso}}" name="piso">
            </div>
            <div class="perfil_dataname">
                <label>Estado civil:</label>
                <select class="px-2 rounded campo_info" name="estado_civil">
                    <option @if($alumno->estado_civil==0) selected @endif value="0">soltero</option>
                    <option @if($alumno->estado_civil==1) selected @endif value="1">casado</option>
                </select>
            </div>
            <div class="perfil_dataname">
                <label >Email:</label>
                <input class="px-2 rounded campo_info" value="{{old('email')? old('email'):$alumno->email}}" name="email">
            </div>
            <div class="perfil_dataname">
                <label>Titulo anterior:</label>
                <input class="px-2 rounded campo_info" value="{{old('titulo_anterior')? old('titulo_anterior'):$alumno->titulo_anterior}}" name="titulo_anterior">
            </div>
            <div class="perfil_dataname">
                <label >Becas:</label>
                <input class="px-2 rounded campo_info" value="{{old('becas')? old('becas'):$alumno->becas}}" name="becas">
            </div>
            <div class="perfil_dataname">
                <label class="w-100p">Observaciones:</label>
                <textarea value="{{old('observaciones')? old('observaciones'):$alumno->observaciones}}" name="observaciones" rows="10"></textarea>
            </div>

            <div class="perfil_dataname">
                <label >Telefono:</label>
                <input class="px-2 rounded campo_info" value="{{old('telefono1')? old('telefono1'):$alumno->telefono1}}" name="telefono1">
            </div>
            <div class="perfil_dataname">
                <label >Telefono 2:</label>
                <input class="px-2 rounded campo_info" value="{{old('telefono2')? old('telefono2'):$alumno->telefono2}}" name="telefono2">
            </div>
            <div class="perfil_dataname">
                <label >Telefono 3:</label>
                <input class="px-2 rounded campo_info" value="{{old('telefono3')? old('telefono3'):$alumno->telefono3}}" name="telefono3">
            </div>
            <div class="perfil_dataname">
                <label >Codigo postal:</label>
                <input class="px-2 rounded campo_info" value="{{old('codigo_postal')? old('codigo_postal'):$alumno->codigo_postal}}" value="6500" name="codigo_postal">
            </div>

            <div class="upd"><input class="btn_borrar upd" type="submit" value="Actualizar"></div>
            </div>
       </form>
    </div>

    
    
    <div class="perfil_one br">
        <div class="perfil__header">
            <h2>Rematriculación manual</h2>
        </div>
        <div class="matricular">
            <form action="{{route('admin.alumno.rematricular',['alumno' => $alumno->id])}}">
                <select class="px-2 rounded" name="carrera" id="">
                    @foreach ($carreras as $carrera)
                        <option value="{{$carrera->id}}">{{$carrera->nombre}}</option>
                    @endforeach
                </select>
                <div class="upd"><button class="btn_edit">Matricular</button></div>
            </form>
        </div>
    </div>
   
    

    <div class="table">
        <div class="table__header">
        <h2>Cursadas</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Materia</th>
                    {{-- <th>Año</th> --}}
                    {{-- <th>Carrera</th> --}}
                    <th>Condicion</th>
                    <th class="center">Aprobada</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody class="table__body">

            @php
                $carrera_actual = "";
                $anio_actual = "";
            @endphp

            @foreach($cursadas as $cursada)

                {{-- @dd($cursada) --}}
                @if ($carrera_actual != $cursada->carrera)
                    <tr>
                        <td class="center font-600 tit-year2" colspan=5>{{$cursada->carrera}}</td>
                    </tr>
                    @php  
                        $carrera_actual = $cursada->carrera;
                        $anio_actual = "";
                    @endphp
                @endif
  

                @if ($anio_actual != $cursada->anio_asig)
                    <tr>
                        <td class="center font-600 tit-year" colspan=5>
                            Año: {{$cursada->anio_asig+1}}
                        </td>
                    </tr>
                    @php
                            $anio_actual = $cursada->anio_asig
                    @endphp
                @endif
  

                <tr>
                    <td>{{$cursada->asignatura}}</td>
    
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
                    <td class="center">
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

    <div class="table">
        <div class="table__header">
            <h2>Examenes</h2>
            <p>Importante: algunos examanes de alumnos mas antiguos podrian no tener datos sobre las mesas.
            </p>
        </div>
            <table class="table__body">
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
                                <td class="center font-600 tit-year2" colspan=4>{{$examen->carrera}}</td>
                            </tr>
                            @php  
                                $carrera_actual = $examen->carrera;
                                $anio_actual = "";
                            @endphp
                        @endif
    

                        @if ($anio_actual != $examen->anio_asig)
                            <tr>
                                <td class="center font-600 tit-year" colspan=4>
                                    Año: {{$examen->anio_asig+1}}
                                </td>
                            </tr>
                            @php
                                    $anio_actual = $examen->anio_asig
                            @endphp
                        @endif

                        <tr>
                            <td>{{$examen->asignatura}}</td>
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
