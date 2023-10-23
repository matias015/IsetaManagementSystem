@extends('Admin.template')

@section('content')
    <div>
        <div class="perfil_one br">
            <div class="perfil__header">
                <h2>Crear nuevo inscripto</h2>
            </div>
            <div class="perfil__info">
                <form method="post" action="{{route('admin.inscriptos.store')}}">
                @csrf

                    <div class="perfil_dataname">
                        <label>Alumno:</label>
                        <select class="campo_info rounded" name="id_alumno">
                            @foreach ($alumnos as $alumno)
                            <option value="{{$alumno->id}}">{{$textFormatService->ucwords($alumno->apellido.' '.$alumno->nombre)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="perfil_dataname">
                        <label>Carrera:</label>
                        <select class="campo_info rounded" name="id_carrera">
                            @foreach ($carreras as $carrera)
                            <option value="{{$carrera->id}}">{{$textFormatService->ucfirst($carrera->nombre)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="perfil_dataname">
                        <label>Año inscripcion:</label>
                        <input class="campo_info rounded"  name="anio_inscripcion">
                    </div>
                    <div class="perfil_dataname">
                        <label>Indice libro matriz:</label>
                        <input class="campo_info rounded" name="indice_libro_matriz">
                    </div>
                    <div class="perfil_dataname">
                        <label>Año finalizacion:</label>
                        <input class="campo_info rounded" name="anio_finalizacion">
                    </div>
                    <div class="upd"><input class="btn_borrar upd" type="submit" value="Crear"></div>
                </form>
            </div>
        </div>
    </div>
@endsection
