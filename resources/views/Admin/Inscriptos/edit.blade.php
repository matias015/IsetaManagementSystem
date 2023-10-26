@extends('Admin.template')

@section('content')
    <div>
        <div class="perfil_one br">
            <div class="perfil__header">
                <h2>Ficha inscripto</h2>
            </div>
            <div class="perfil__info">
                <form method="post" action="{{route('admin.inscriptos.update', ['inscripto' => $registro->id])}}">
                @csrf
                @method('put')

                    <div class="perfil_dataname">
                        <label>Alumno:
                        <span class="campo_info2">{{$registro->alumno->apellido.' '.$registro->alumno->nombre}}</span>
                    </label>
                    </div>
                    <div class="perfil_dataname">
                        <label>Carrera:</label>
                        <span class="campo_info2">{{$registro->carrera->nombre}}</span>
                    </div>
                    <div class="perfil_dataname">
                        <label>Año inscripcion:</label>
                        <input class="campo_info rounded" value="{{$registro->anio_inscripcion}}" name="anio_inscripcion">
                    </div>
                    <div class="perfil_dataname">
                        <label>Indice libro matriz:</label>
                        <input class="campo_info rounded" value="{{$registro->indice_libro_matriz}}" name="indice_libro_matriz">
                    </div>
                    <div class="perfil_dataname">
                        <label>Año finalizacion:</label>
                        <input class="campo_info rounded" value="{{$registro->anio_finalizacion}}" name="anio_finalizacion">
                    </div>

                    <div class="upd"><input class="btn_borrar upd" type="submit" value="Editar"></div>
                </form>
            </div>
        </div>
        <p class="center">En progreso</p>
    </div>
@endsection
