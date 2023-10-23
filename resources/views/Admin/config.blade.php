@extends('Admin.template')

@section('content')

    <div class="perfil_one br">
        <div class="perfil__header">
            <h2>Configuración</h2>
        </div>
        <div class="perfil__info">

            <form method="POST" action="{{route('admin.config.set')}}">
                @csrf
                <div class="perfil_dataname">
                    <label>Filas por tabla:</label>
                    <input class="campo_info rounded" name="filas_por_tabla" value="{{$configuracion['filas_por_tabla'] ? $configuracion['filas_por_tabla'] : ''}}" name="filas_por_tabla">
                </div>
                <div class="perfil_dataname">
                    <label>Horas habiles de inscripcion:</label>
                    <input class="campo_info rounded" name="horas_habiles_inscripcion" value="{{$configuracion['horas_habiles_inscripcion'] ? $configuracion['horas_habiles_inscripcion'] : ''}}" name="filas_por_tabla">
                </div>
                <div class="perfil_dataname">
                    <label>Horas habiles de desinscripcion:</label>
                    <input class="campo_info rounded" name="horas_habiles_desinscripcion" value="{{$configuracion['horas_habiles_desinscripcion'] ? $configuracion['horas_habiles_desinscripcion'] : ''}}" name="filas_por_tabla">
                </div>
                <div class="perfil_dataname">
                    <label>Fechas de rematriculacion:</label>
                    <input class="campo_info rounded" type="date" name="fecha_inicial_rematriculacion" value="{{$configuracion['fecha_inicial_rematriculacion'] ? $configuracion['fecha_inicial_rematriculacion'] : ''}}" >
                </div>
                <div class="perfil_dataname">
                    <label>Fechas de rematriculacion:</label>
                    <input class="campo_info rounded" type="date" name="fecha_final_rematriculacion" value="{{$configuracion['fecha_final_rematriculacion'] ? $configuracion['fecha_final_rematriculacion'] : ''}}" name="fecha_final_rematriculacion">
                </div>
                <div class="perfil_dataname">
                    <label>Fechas de rematriculacion:</label>
                    <input class="campo_info rounded" type="number" name="anio_remat" value="{{$configuracion['anio_remat'] ? $configuracion['anio_remat'] : ''}}" name="anio_remat">
                </div>
                <div class="perfil_dataname">
                    <label>Fechas limite para revertir rematriculacion:</label>
                    <input class="campo_info rounded" type="date" name="fecha_limite_desrematriculacion" value="{{$configuracion['fecha_limite_desrematriculacion'] ? $configuracion['fecha_limite_desrematriculacion'] : ''}}">
                </div>
                <div class="perfil_dataname">
                    <label>Diferencia maxima entre llamado 1 y 2 en dias:</label>
                    <input class="campo_info rounded" type="number" name="diferencia_llamados" value="{{$configuracion['diferencia_llamados'] ? $configuracion['diferencia_llamados'] : ''}}">
                </div>

                <div class="upd"><button class="btn_edit">Aplicar</button></div>

            </form>
        </div>
    </div>
    
@endsection
