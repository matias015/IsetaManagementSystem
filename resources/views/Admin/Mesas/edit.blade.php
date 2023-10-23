@extends('Admin.template')

@section('content')
    <div class="edit-form-container">
        <div class="perfil_one br">
            <div class="perfil__header">
                <h2>{{$mesa->materia->nombre}}</h2>
            </div>
            <div class="perfil__info">
                <form method="post" action="{{route('admin.mesas.update', ['mesa'=>$mesa->id])}}">
                @csrf
                @method('put')

                    <div class="perfil_dataname">
                        <label>Fecha:</label>
                        <input type="datetime-local" class="campo_info rounded" value="{{$mesa->fecha}}" name="fecha">
                    </div>
                    <div class="perfil_dataname">
                        <label>Llamado:</label>
                        <select class="campo_info rounded" name="llamado">
                            <option @selected($mesa->llamado==1) value="1">Primero</option>
                            <option @selected($mesa->llamado==2) value="2">Segundo</option>
                        </select>
                    </div>
                    <div class="perfil_dataname">
                        <label>Prof. presidente:</label>
                        <select class="campo_info rounded" name="prof_presidente">
                            <option @selected($mesa->prof_presidente==0) value="vacio">Vacio/A confirmar</option>
                            @foreach($profesores as $profesor)
                            <option @selected($mesa->prof_presidente != 0 && $mesa->profesor->id == $profesor->id) value="{{$profesor->id}}">
                                {{$textFormatService->ucwords($profesor->apellido . ' ' . $profesor->nombre)}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="perfil_dataname">
                        <label>Prof. vocal 1:</label>
                        <select class="campo_info rounded" name="prof_vocal_1">
                            <option @selected($mesa->prof_vocal_1==0) value="vacio">Vacio/A confirmar</option>

                        @foreach($profesores as $profesor)
                            <option @selected($mesa->prof_vocal_1 != 0 && $mesa->vocal1->id == $profesor->id) value="{{$profesor->id}}">
                                {{$textFormatService->ucwords($profesor->apellido . ' ' . $profesor->nombre)}}
                            </option>
                        @endforeach
                        </select>
                    </div>
                    <div class="perfil_dataname">
                        <label>Prof. vocal 2:</label>
                        <select class="campo_info rounded" name="prof_vocal_2">
                            <option @selected($mesa->prof_vocal_2==0) value="vacio">Vacio/A confirmar</option>
                        @foreach($profesores as $profesor)
                            <option @selected($mesa->prof_vocal_2 != 0 && $mesa->vocal2 && $mesa->vocal2->id == $profesor->id) value="{{$profesor->id}}">
                                {{$textFormatService->ucwords($profesor->apellido . ' ' . $profesor->nombre)}}

                            </option>
                        @endforeach
                        </select>
                    </div>

                    <div class="upd"><input type="submit" value="Actualizar" class="btn_borrar"></div>
                </form>
            </div>
        </div>

            <div class="perfil_one br">
                {{-- <p>La funcion de agregar alumnos se elimino hasta que se arreglen algunos errores</p> --}}
                <div class="perfil__header">
                    <h2>Alumnos inscriptos</h2>
                </div>
                <div class="matricular">
                    <p>Agregar alumno</p>
                    <p>
                     @if(strtotime($mesa->fecha) > time())
                        Estos alumnos han aprobado la cursada de esta materia, luego se volvera a validar sobre correlativas y tiempos
                    
                        <form method="POST" action="{{route('admin.examenes.store')}}">
                    @csrf
                            <select class="rounded" name="id_alumno">
                                    <option value=""></option>
                                @foreach ($inscribibles as $inscribible)
                                    <option value="{{$inscribible->id}}">{{$textFormatService->ucwords($inscribible->apellido.' '.$inscribible->nombre)}}</option>
                                @endforeach
                            </select>
                            <input name="id_mesa" value="{{$mesa->id}}" type="hidden">
                            <div class="upd"><input type="submit" value="Agregar" class="btn_borrar"></div>
                        </form>
                    
                    @else
                        Ya no se pueden agregar alumnos    
                    @endif
                    </p>
                </div>
            </div>
            <div class="table">
                <div class="table__header">
                    <h2>Acta volante</h2>
                    <div class="flex just-center">
                        <a href="{{route('admin.mesas.acta', ['mesa'=>$mesa->id])}}" target="_blank"><button class="btn_edit wit3">Regular</button></a>
                        <a href="{{route('admin.mesas.actaprom', ['mesa'=>$mesa->id])}}" target="_blank"><button class="btn_edit wit3">Promocion</button></a>
                        <a href="{{route('admin.mesas.actalibre', ['mesa'=>$mesa->id])}}" target="_blank"><button class="btn_edit wit3">Libres</button></a>

                    </div>
                </div>
        
                <table class="table__body">
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
                                    <input type="submit" value="Eliminar" class="btn_borrar">
                                    </form> 
                                --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    </div>
@endsection
