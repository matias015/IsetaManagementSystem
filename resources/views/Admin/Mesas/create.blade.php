@extends('Admin.template')

@section('content')
    <div>
        <div class="perfil_one br">
            <div class="perfil__header">
                <h2>Crear nueva mesa</h2>
            </div>
            <div class="perfil__info">
                <div class="perfil_dataname">
                    <label>Carrera:</label>
                    <select class="campo_info rounded" name="carrera" id="carrera_select">
                        <option value="any">Selecciona una carrera</option>
                        @foreach ($carreras as $carrera)
                        <option @selected($precargados['carrera'] == $carrera->id) value="{{$carrera->id}}">
                            {{$carrera->nombre}}
                        </option>
                        @endforeach
                    </select>
                </div>

                <form method="post" action="{{route('admin.mesas.store')}}">
                @csrf

                <div class="perfil_dataname">
                    <label>Materia:</label>
                    <select class="campo_info rounded" id="asignatura_select" name="id_asignatura">
                    @if ($precargados['asignatura'])
                        <option selected value="{{$precargados['asignatura']->id}}">{{$precargados['asignatura']->nombre}}</option>
                    @endif
                        <option value="">Selecciona una carrera</option>
                    </select>
                </div>
                <div class="perfil_dataname">
                    <label>Profesor:</label>
                    <select class="profesor campo_info rounded" name="prof_presidente">
                        <option selected value="0">Vacio/A confirmar</option>
                        @foreach ($profesores as $profesor)
                        <option value="{{$profesor->id}}">
                            {{$profesor->apellido . ' ' . $profesor->nombre}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="perfil_dataname">
                    <label>Profesor 1:</label>
                    <select class="profesor campo_info rounded" name="prof_vocal_1">
                        <option selected value="0">Vacio/A confirmar</option>
                        @foreach ($profesores as $profesor)
                        <option value="{{$profesor->id}}">
                            {{$profesor->apellido . ' ' . $profesor->nombre}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="perfil_dataname">
                    <label>Profesor 2:</label>
                    <select class="profesor campo_info rounded" name="prof_vocal_2">
                        <option selected value="0">Vacio/A confirmar</option>
                        @foreach ($profesores as $profesor)
                        <option value="{{$profesor->id}}">
                            {{$profesor->apellido . ' ' . $profesor->nombre}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="perfil_dataname">
                    <label>Llamado:</label>
                    <select class="campo_info rounded" name="llamado">
                        <option @selected(old('llamado')=='1') value="1">Primero</option>
                        <option @selected(old('llamado')=='2') value="2">Segundo</option>
                    </select>
                </div>
                <div class="perfil_dataname">
                    <label>Fecha:</label>
                    <input class="campo_info rounded" value="{{old('fecha')?old('fecha'):''}}" type="datetime-local" name="fecha">
                </div>

                <div class="upd"><input class="btn_borrar upd" type="submit" value="Crear"></div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{asset('js/obtener-materias.js')}}"></script>

@endsection
