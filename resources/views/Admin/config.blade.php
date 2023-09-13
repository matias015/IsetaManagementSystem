@extends('Admin.template')

@section('content')

    <div class="perfil_one table">

        <form method="POST" action="{{route('admin.config.set')}}">
            @csrf
            <span class="perfil_dataname">Filas por tabla: <input class="campo_info" name="filas_por_tabla" value="{{$configuracion['filas_por_tabla'] ? $configuracion['filas_por_tabla'] : ''}}" name="filas_por_tabla"></span>
            <span class="perfil_dataname">Horas habiles de inscripcion: <input class="campo_info" name="horas_habiles_inscripcion" value="{{$configuracion['horas_habiles_inscripcion'] ? $configuracion['horas_habiles_inscripcion'] : ''}}" name="filas_por_tabla"></span>
            <span class="perfil_dataname">Horas habiles de desinscripcion: <input class="campo_info" name="horas_habiles_desinscripcion" value="{{$configuracion['horas_habiles_desinscripcion'] ? $configuracion['horas_habiles_desinscripcion'] : ''}}" name="filas_por_tabla"></span>
            <span class="perfil_dataname">Fechas de rematriculacion: <input class="campo_info" type="date" name="fecha_inicial_rematriculacion" value="{{$configuracion['fecha_inicial_rematriculacion'] ? $configuracion['fecha_inicial_rematriculacion'] : ''}}" ></span>
            <span class="perfil_dataname">Fechas de rematriculacion: <input class="campo_info" type="date" name="fecha_final_rematriculacion" value="{{$configuracion['fecha_final_rematriculacion'] ? $configuracion['fecha_final_rematriculacion'] : ''}}" name="fecha_final_rematriculacion"></span>
            <span class="perfil_dataname">Fechas de rematriculacion: <input class="campo_info" type="number" name="anio_remat" value="{{$configuracion['anio_remat'] ? $configuracion['anio_remat'] : ''}}" name="anio_remat"></span>
            <span class="perfil_dataname">Fechas limite para revertir rematriculacion: <input class="campo_info" type="date" name="fecha_limite_desrematriculacion" value="{{$configuracion['fecha_limite_desrematriculacion'] ? $configuracion['fecha_limite_desrematriculacion'] : ''}}"></span>
            <span class="perfil_dataname">Diferencia maxima entre llamado 1 y 2 en dias: <input class="campo_info" type="number" name="diferencia_llamados" value="{{$configuracion['diferencia_llamados'] ? $configuracion['diferencia_llamados'] : ''}}"></span>

            <div class="upd"><button class="btn_edit">Aplicar</button></div>

        </form>


    </div>
    
@endsection
