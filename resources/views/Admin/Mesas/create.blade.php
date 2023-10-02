@extends('Admin.template')

@section('content')
    <div>

        <div class="perfil_one table">
        <span class="perfil_dataname">Carrera:
            <select class="campo_info" name="carrera" id="carrera_select">
                <option value="any">Selecciona una carrera</option>
                @foreach ($carreras as $carrera)
                    <option value="{{$carrera->id}}">
                        {{$textFormatService->ucfirst($carrera->nombre)}}
                    </option>
                @endforeach
            </select>
        </span>

       <form method="post" action="{{route('admin.mesas.store')}}">
        @csrf

        <span class="perfil_dataname">
            Materia:
            <select class="campo_info" id="asignatura_select" name="id_asignatura">
                <option value="">selecciona una carrera</option>
            </select>
        </span>
        <span class="perfil_dataname">
            Profesor: 
            <select class="profesor campo_info" name="prof_presidente">
                <option selected value="vacio">vacio/A confirmar</option>
                @foreach ($profesores as $profesor)
                    <option value="{{$profesor->id}}">
                        {{$textFormatService->ucwords($profesor->apellido . ' ' . $profesor->nombre)}}
                    </option>
                @endforeach
            </select>
        </span>
        <span class="perfil_dataname">
            Profesor 1:
            <select class="profesor campo_info" name="prof_vocal_1">
                <option selected value="vacio">vacio/A confirmar</option>
                @foreach ($profesores as $profesor)
                    <option value="{{$profesor->id}}">
                        {{$textFormatService->ucwords($profesor->apellido . ' ' . $profesor->nombre)}}

                    </option>
                @endforeach
            </select>
        </span>
        <span class="perfil_dataname">
            Profesor 2:
            <select class="profesor campo_info" name="prof_vocal_2">
                <option selected value="vacio">vacio/A confirmar</option>
                @foreach ($profesores as $profesor)
                    <option value="{{$profesor->id}}">
                        {{$textFormatService->ucwords($profesor->apellido . ' ' . $profesor->nombre)}}

                    </option>
                @endforeach
            </select>
            </span>

        <span class="perfil_dataname">
            Llamado:
            <select class="campo_info" name="llamado">
                <option @selected(old('llamado')=='1') value="1">Primero</option>
                <option @selected(old('llamado')=='2') value="2">Segundo</option>
            </select>
            </span>

        <span class="perfil_dataname">
            Fecha:
            <input class="campo_info" value="{{old('fecha')?old('fecha'):''}}" type="datetime-local" name="fecha">
        </span>

        <div class="upd"><input class="btn_borrar upd" type="submit" value="Crear"></div>
       </form>
    </div>
    </div>

    <script src="{{asset('js/obtener-materias.js')}}"></script>

@endsection
