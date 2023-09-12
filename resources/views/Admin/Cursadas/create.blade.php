@extends('Admin.template')

@section('content')
    <div>

        <div class="perfil_one table">
        <span class="perfil_dataname">Carrera:
        <select class="campo_info" name="carrera" id="carrera_select">
            <option selected >Selecciona una carrera</option>
            @foreach ($carreras as $carrera)
                <option value="{{$carrera->id}}">{{$carrera->nombre}}</option>
            @endforeach
        </select>
        </span>

       <form method="post" action="{{route('admin.cursadas.store')}}">
        @csrf

        <span class="perfil_dataname">
            Materia: 
            <select id="asignatura_select" class="asignatura campo_info" name="id_asignatura">
                <option value="">selecciona una carrera</option>
            </select>
        </span>
        <span class="perfil_dataname">
            Alumno: 
            <select class="alumno campo_info" name="id_alumno">
                <option selected>selecciona un alumno</option>
                @foreach($alumnos as $alumno)
                    <option value="{{$alumno->id}}">{{$alumno->nombre.' '.$alumno->apellido}}</option>
                @endforeach
            </select>
        </span>


        <span class="perfil_dataname">Año de cursada: <input class="campo_info" placeholder="2023" name="anio_cursada"></span>
        <span class="perfil_dataname">Condicion: 
            <select class="campo_info" name="condicion">
                <option value="1">Libre</option>
                <option selected value="2">Presencial</option>
                <option value="3">Desertor</option>    
                <option value="4">Atraso acadamico</option>
                <option value="5">Otro</option>
            </select>    
        </span>

        <div class="upd"><input class="btn_borrar upd" type="submit" value="Crear"></div>
       </form>
    </div>
    </div>
    <script src="{{asset('js/obtener-materias.js')}}"></script>
@endsection
