@extends('Admin.template')

@section('content')
    <div>
        <div class="perfil_one br">
            <div class="perfil__header">
                <h2>Crear nueva cursada</h2>
            </div>
            <div class="perfil__info">
                <div class="perfil_dataname">
                    <label>Carrera:</label>
                    <select class="campo_info rounded" name="carrera" id="carrera_select">
                        <option selected >Selecciona una carrera</option>
                        @foreach ($carreras as $carrera)
                        <option value="{{$carrera->id}}">{{$carrera->nombre}}</option>
                        @endforeach
                    </select>
                </div>

            <form method="post" action="{{route('admin.cursadas.store')}}">
            @csrf

                <div class="perfil_dataname">
                    <label>Materia:</label>
                    <select id="asignatura_select" class="asignatura campo_info rounded" name="id_asignatura">
                        <option value="">Selecciona una carrera</option>
                    </select>
                </div>
                <div class="perfil_dataname">
                    <label>Alumno:</label>
                    <select class="alumno campo_info rounded" name="id_alumno">
                        <option selected>Selecciona un alumno</option>
                        @foreach($alumnos as $alumno)
                        <option value="{{$alumno->id}}">{{$alumno->nombre.' '.$alumno->apellido}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="perfil_dataname">
                    <label>Año de cursada:</label>
                    <input class="campo_info rounded" placeholder="2023" name="anio_cursada">
                </div>
                <div class="perfil_dataname">
                    <label>Condicion:</label>
                    <select class="campo_info rounded" name="condicion">
                        <option value="1">Libre</option>
                        <option selected value="2">Regular</option>
                        <option value="3">Desertor</option>    
                        <option value="4">Atraso acadamico</option>
                        <option value="5">Otro</option>
                    </select>
                </div>
                <div class="upd"><input class="btn_borrar upd" type="submit" value="Crear"></div>
            </form>
            </div>
        </div>
    </div>
    <script src="{{asset('js/obtener-materias.js')}}"></script>
@endsection
