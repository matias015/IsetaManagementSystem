@extends('Admin.template')

@section('content')
    <div>
        <div class="edit-form-container">
            <div class="perfil_one table">
                <h2>{{$mesa->materia->nombre}}</h2>
                <form method="post" action="{{route('admin.mesas.update', ['mesa'=>$mesa->id])}}">
                @csrf
                @method('put')

                    <span class="perfil_dataname">Fecha: 
                        <input type="datetime-local" class="campo_info" value="{{$mesa->fecha}}" name="fecha">
                    </span>
                    
                    <span class="perfil_dataname">Llamado: 
                        <select class="campo_info" name="llamado">
                            <option @selected($mesa->llamado==1) value="1">Primero</option>
                            <option @selected($mesa->llamado==2) value="2">Segundo</option>
                        </select>
                    </span>

                    <span class="perfil_dataname">Prof. presidente:
                        <select class="campo_info" name="prof_presidente">
                            <option @selected($mesa->prof_presidente==0) value="vacio">vacio/A confirmar</option>
                            @foreach($profesores as $profesor)
                            <option @selected($mesa->prof_presidente != 0 && $mesa->profesor->id == $profesor->id) value="{{$profesor->id}}">
                                {{$textFormatService->ucwords($profesor->apellido . ' ' . $profesor->nombre)}}
                            </option>
                            @endforeach
                        </select>
                    </span>
                    <span class="perfil_dataname">Prof. vocal 1:
                        <select class="campo_info" name="prof_vocal_1">
                            <option @selected($mesa->prof_vocal_1==0) value="vacio">vacio/A confirmar</option>

                        @foreach($profesores as $profesor)
                            <option @selected($mesa->prof_vocal_1 != 0 && $mesa->vocal1->id == $profesor->id) value="{{$profesor->id}}">
                                {{$textFormatService->ucwords($profesor->apellido . ' ' . $profesor->nombre)}}
                            </option>
                        @endforeach
                        </select>
                    </span>
                    <span class="perfil_dataname">Prof. vocal 2:
                        <select class="campo_info" name="prof_vocal_2">
                            <option @selected($mesa->prof_vocal_2==0) value="vacio">vacio/A confirmar</option>
                        @foreach($profesores as $profesor)
                            <option @selected($mesa->prof_vocal_2 != 0 && $mesa->vocal2 && $mesa->vocal2->id == $profesor->id) value="{{$profesor->id}}">
                                {{$textFormatService->ucwords($profesor->apellido . ' ' . $profesor->nombre)}}

                            </option>
                        @endforeach
                        </select>
                    </span>

                    <div class="upd"><input type="submit" value="Actualizar" class="btn_borrar"></div>
                </form>
            </div>

            <div class="perfil_one table">
                {{-- <p>La funcion de agregar alumnos se elimino hasta que se arreglen algunos errores</p> --}}
                <h2>Alumnos inscriptos</h2>
                    <p>Agregar alumno</p>
                    <p>

                     @if(strtotime($mesa->fecha) > time())
        
                        estos alumnos han aprobado la cursada de esta materia, luego se volvera a validar sobre correlativas y tiempos
            
                        <form method="POST" action="{{route('admin.examenes.store')}}">
                    @csrf
                
                            <select name="id_alumno">
                                <option value=""></option>
                            @foreach ($inscribibles as $inscribible)
                                <option value="{{$inscribible->id}}">{{$textFormatService->ucwords($inscribible->apellido.' '.$inscribible->nombre)}}</option>
                            @endforeach
                
                            </select>
                            <input name="id_mesa" value="{{$mesa->id}}" type="hidden">
                            <input type="submit" value="Agregar">
                        </form>
                    @else
                        Ya no se pueden agregar alumnos    
                    @endif
                    </p>
            </div>
            <div class="table">
                <div class="table__header">
                    <a href="{{route('admin.mesas.acta', ['mesa'=>$mesa->id])}}" target="_blank"><button class="btn_edit wit3">Acta volante</button></a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Alumno</th>
                            <th>Nota</th>
                            <th>Cosas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alumnos as $alumno)
                        <tr>
                            <td>{{$textFormatService->ucwords($alumno->apellido . ' ' . $alumno->nombre)}}</td>
                            
                            <td>{{$alumno->nota!=0? $alumno->nota : 'Sin nota'}}</td>
                            <td>
                                <a href="{{route('admin.examenes.edit', ['examen' => $alumno->id_examen])}}">
                                    <button class="btn_edit">Ver</button>
                                </a>
                                {{-- <form method="POST" action="{{route('admin.examenes.destroy', ['examen' => $alumno->id_examen])}}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="Eliminar">
                                    </form> 
                                --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
