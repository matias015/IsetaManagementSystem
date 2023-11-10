@extends('Admin.template')

@section('content')

    <div class="perfil_one br">
        <div class="perfil__header">
            <h2>Configuración</h2>
        </div>
        <div class="perfil__info">

            <form class="flex-col gap-10" method="POST" class="" action="{{route('admin.config.set')}}">
                @csrf
   
                <div class="flex-col items-start items-start perfil_dataname">
                    <div class="flex w-100p">
                        <label>Filas por tabla:</label>
                        <input class="campo_info rounded" name="filas_por_tabla" value="{{$configuracion['filas_por_tabla'] ? $configuracion['filas_por_tabla'] : ''}}" name="filas_por_tabla">
                    </div>
                    <p class="font-200 wrap text-left font-5">Cuantas filas se mostraran en las tablas principales de datos.</p>
                </div>

                <div class="flex-col items-start perfil_dataname">
                    <div class="flex w-100p">
                        <label>Horas habiles de inscripcion:</label>
                        <input class="campo_info rounded" name="horas_habiles_inscripcion" value="{{$configuracion['horas_habiles_inscripcion'] ? $configuracion['horas_habiles_inscripcion'] : ''}}" name="filas_por_tabla">
                    </div>
                    <p class="font-200 wrap text-left font-5">Horas habiles previas limite a la fecha de una mesa para su inscripcion.</p>
                </div>

                <div class="flex-col items-start perfil_dataname">
                    <div class="flex w-100p">
                       <label>Horas habiles de desinscripcion:</label>
                        <input class="campo_info rounded" name="horas_habiles_desinscripcion" value="{{$configuracion['horas_habiles_desinscripcion'] ? $configuracion['horas_habiles_desinscripcion'] : ''}}" name="filas_por_tabla">
                    </div>
                    <p class="font-200 wrap text-left font-5">Horas habiles previas limite a la fecha de una mesa para su desinscripcion.</p>
                </div>
                
                <div class="flex-col gap-2 items-start perfil_dataname">
                    <div class="flex w-100p">
                        <label>Fechas de rematriculacion:</label>
                        <input class="campo_info rounded" type="date" name="fecha_inicial_rematriculacion" value="{{$configuracion['fecha_inicial_rematriculacion'] ? $configuracion['fecha_inicial_rematriculacion'] : ''}}" >
                    </div>
                    <p class="font-200 wrap text-left font-5">Fecha inicial de la etapa de rematriculacion mediante el sitio web. A partir de esta fecha los alumnos podran anotarse a cursadas por su cuenta.</p>
                    <p class="font-600 wrap text-left font-5">Es necesario actualizar este valor cada año.</p>

                </div>

                <div class="flex-col items-start perfil_dataname">
                    <div class="flex w-100p">
                        <label>Fechas de rematriculacion:</label>
                        <input class="campo_info rounded" type="date" name="fecha_final_rematriculacion" value="{{$configuracion['fecha_final_rematriculacion'] ? $configuracion['fecha_final_rematriculacion'] : ''}}" name="fecha_final_rematriculacion">
                    </div>
                    <p class="font-200 wrap text-left font-5">Fecha final de la etapa de rematriculacion mediante el sitio web.</p>
                </div>
                
                <div class="flex-col gap-2 items-start perfil_dataname">
                    <div class="flex w-100p">
                        <label>Año de rematriculacion:</label>
                        <input class="campo_info rounded" type="number" name="anio_remat" value="{{$configuracion['anio_remat'] ? $configuracion['anio_remat'] : ''}}" name="anio_remat">
                    </div>
                    <p class="font-200 wrap text-left font-5">Año correspondiente a las cursadas del proximo ciclo lectivo. Los reportes sobre las nuevas cursadas se basan en esta configuracion. No es recomendable su modificacion hasta el inicio del nuevo ciclo de rematriculacion e inscripciones. Tambien sera el año de cursada fijado para la inscripcion a cursadas cuando los alumnos se matriculan por su cuenta.</p>
                    <p class="font-600 wrap text-left font-5">Es necesario actualizar este valor cada año.</p>
                </div>

                <div class="flex-col gap-2 items-start perfil_dataname">
                    <div class="flex w-100p">
                        <label>Año del ciclo actual:</label>
                        <input class="campo_info rounded" type="number" name="anio_ciclo_actual" value="{{$configuracion['anio_ciclo_actual'] ? $configuracion['anio_ciclo_actual'] : ''}}" name="anio_remat">
                    </div>
                    <p class="font-200 wrap text-left font-5">Año correspondiente actual o a aquel que se quiera analizar, por ejemplo, si se desea obtener informes de cursadas o modificacion en lote de estas, se usara este valor como filtro del año.</p>
                    <p class="font-600 wrap text-left font-5">Es necesario actualizar este valor cada año.</p>
                </div>

                <div class="flex-col gap-2 items-start perfil_dataname">
                    <div class="flex w-100p">
                        <label>Fechas limite para revertir rematriculacion:</label>
                        <input class="campo_info rounded" type="date" name="fecha_limite_desrematriculacion" value="{{$configuracion['fecha_limite_desrematriculacion'] ? $configuracion['fecha_limite_desrematriculacion'] : ''}}">
                    </div>
                    <p class="font-200 wrap text-left font-5">Hasta que fecha los alumnos pueden desinscribirse o bajarse de una cursada, si se deja una fecha menor a hoy, los alumnos no podran bajarse de las cursadas. No es recomendable su modificacion hasta el inicio del nuevo ciclo de rematriculacion e inscripciones.</p>
                    <p class="font-600 wrap text-left font-5">Es necesario actualizar este valor cada año.</p>

                </div>

                <div class="flex-col items-start perfil_dataname">
                    <div class="flex w-100p">
                        <label>Diferencia maxima entre llamado 1 y 2 en dias:</label>
                        <input class="campo_info rounded" type="number" name="diferencia_llamados" value="{{$configuracion['diferencia_llamados'] ? $configuracion['diferencia_llamados'] : ''}}">
                    </div>
                    <p class="font-200 wrap text-left font-5">Tiempo maximo en dias de diferencia entre los dos llamados de una misma mesa, la diferencia cuenta hacia ambos lados con respecto a la fecha del llamado que se este manejando. Es utilizado internamente para prevenir comportamientos inesperados en el sitio web, como la inscripcion de un alumno al llamado 2 luego de haber desaprobado el llamado 1.</p>
                </div>

                <div class="upd"><button class="btn_edit">Aplicar</button></div>

            </form>
        </div>
    </div>
    
@endsection
