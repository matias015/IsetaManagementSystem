@extends('Admin.template')

@section('content')

    <div>

        <form method="POST" action="{{route('admin.config.set')}}">
            @csrf
            <p>Filas por tabla <input name="filas_por_tabla" value="{{$configuracion['filas_por_tabla'] ? $configuracion['filas_por_tabla'] : ''}}" name="filas_por_tabla"></p>
            <p>Horas habiles de inscripcion <input name="horas_habiles_inscripcion" value="{{$configuracion['horas_habiles_inscripcion'] ? $configuracion['horas_habiles_inscripcion'] : ''}}" name="filas_por_tabla"></p>
            <p>Horas habiles de desinscripcion <input name="horas_habiles_desinscripcion" value="{{$configuracion['horas_habiles_desinscripcion'] ? $configuracion['horas_habiles_desinscripcion'] : ''}}" name="filas_por_tabla"></p>
            <p>Fechas de rematriculacion 
                <input type="date" name="fecha_inicial_rematriculacion" value="{{$configuracion['fecha_inicial_rematriculacion'] ? $configuracion['fecha_inicial_rematriculacion'] : ''}}" >
            </p>
            <p>Fechas de rematriculacion <input type="date" name="fecha_final_rematriculacion" value="{{$configuracion['fecha_final_rematriculacion'] ? $configuracion['fecha_final_rematriculacion'] : ''}}" name="fecha_final_rematriculacion"></p>
            <p>Fechas de rematriculacion <input type="number" name="anio_remat" value="{{$configuracion['anio_remat'] ? $configuracion['anio_remat'] : ''}}" name="anio_remat"></p>
            <p>Fechas limite para revertir rematriculacion <input type="date" name="fecha_limite_desrematriculacion" value="{{$configuracion['fecha_limite_desrematriculacion'] ? $configuracion['fecha_limite_desrematriculacion'] : ''}}"></p>
            <button class="m-2 border-none rounded px-3 py-1 bg-blue-900 white">Aplicar</button>

        </form>


    </div>
    
@endsection
