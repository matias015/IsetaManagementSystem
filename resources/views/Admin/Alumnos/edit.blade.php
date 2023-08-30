@extends('Admin.template')

@section('content')
<div class="edit-form-container">
    <div class="table">
        <div><h2>Datos</h2></div>
            
        <form method="post" action="{{route('admin.alumnos.update', ['alumno'=>$alumno->id])}}">
        @csrf
        @method('put')
        
        <span class="sep1">DNI: <input class="campo_info" value="{{$alumno->dni}}" name="dni"></span>
        <span>Nombre: <input class="campo_info" value="{{$alumno->nombre}}" name="nombre"></span>
        <span>apellido: <input class="campo_info" value="{{$alumno->apellido}}" name="apellido"></span>
        <span>Fecha nacimiento: <input class="campo_info" value="{{$alumno->fecha_nacimiento->format('Y-m-d')}}" type="date" name="fecha_nacimiento"></span>
        <span>ciudad: <input class="campo_info" value="{{$alumno->ciudad}}" value="9 de Julio" name="ciudad"></span>
        <span>calle: <input class="campo_info" value="{{$alumno->calle}}" name="calle"></span>
        <span>numero: <input class="campo_info" value="{{$alumno->numero}}"  name="casa_numero"></span>
        <span>departamento: <input class="campo_info" value="{{$alumno->departamento}}" name="dpto"></span>
        <span>Piso: <input class="campo_info" value="{{$alumno->piso}}" name="piso"></span>
        <span>
            Estado civil: 
            <select class="campo_info" name="estado_civil">
                <option @if($alumno->estado_civil==0) selected @endif value="0">soltero</option>
                <option @if($alumno->estado_civil==1) selected @endif value="1">casado</option>
            </select>
        </span>
        <span>email <input class="campo_info" value="{{$alumno->email}}" name="email"></span>
        <span>titulo anterior <input class="campo_info" value="{{$alumno->titulo_anterior}}" name="titulo_anterior"></span>
        <span>becas <input class="campo_info" value="{{$alumno->becas}}" name="becas"></span>
        
        <span>observaciones <textarea value="{{$alumno->observaciones}}" name="observaciones" cols="100" rows="10"></textarea></span>

        <span>telefono <input class="campo_info" value="{{$alumno->telefono1}}" name="telefono1"></span>
        <span>telefono 2 <input class="campo_info" value="{{$alumno->telefono2}}" name="telefono2"></span>
        <span>telefono 3<input class="campo_info" value="{{$alumno->telefono3}}" name="telefono3"></span>
        <span>codigo postal<input class="campo_info" value="{{$alumno->codigo_postal}}" value="6500" name="codigo_postal"></span>

        <div class="upd"><input class="btn_borrar upd" type="submit" value="Actualizar"></div>
        
        
       </form>
        </table>

       
    </div>

    <br><br>

    

    <div class="table">
        <div>
        <h2>Cursadas</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Materia</th>
                    <th>Año</th>
                    <th>Carrera</th>
                    <th>Aprobada</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach($alumno->cursadas as $cursada)
                <tr>
                    <td>{{$cursada->asignatura->nombre}}</td>
                    <td>{{$cursada->anio_cursada}}</td>
                    <td>{{$cursada->asignatura->carrera->nombre}}</td>
                    <td>
                        @if ($cursada->aprobada==1)
                            Si
                        @elseif($cursada->aprobada==2)
                            No
                        @else
                            Cursando/sin determinar
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

        <h2>examenes</h2>
        
            <p>Importante: algunos examanes de alumnos mas antiguos podrian no tener datos sobre las mesas, debido a que no fueron registradas correctamente por parte de iseta
            </p>
            <table>
                <thead>
                    <tr>
                        <th>Materia</th>
                        <th>Carrera</th>
                        <th>Nota</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alumno->examenes as $examen)
                        <tr>
                            <td>{{$examen->asignatura->nombre}}</td>
                            <td>{{$examen->asignatura->carrera->nombre}}</td>
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
