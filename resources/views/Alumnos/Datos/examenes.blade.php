@extends('Alumnos.layout')

@section('content')
<main id="fondo-estudiantes">
    <section class="table">
<div class="table__header">
          <h1>Examenes</h1>
          
          <form class="none md-block" action="{{route('alumno.examenes')}}">
            <div class="tabla_botonera">
              {{-- <div >
                <p class="promedio">Promedio: {{$promedio}}</p>
              </div> --}}
              
              <div class="contenedor_ordenar">
                <span>Ordenar por</span>
                <select class="ordenar" name="orden">
                  <option @selected($filtros['orden'] == 'asignatura') value="asignatura">Asignatura</option>
                    <option @selected($filtros['orden'] == 'anio') value="anio">Año carrera</option>
                    <option @selected($filtros['orden'] == 'fecha') value="fecha">Año cursada</option>
                    <option @selected($filtros['orden'] == 'anio_desc') value="anio_desc">Año carrera desc</option>
                    <option @selected($filtros['orden'] == 'fecha_desc') value="fecha_desc">Año cursada desc</option>
                </select>
                <i class="ti ti-arrows-down-up i_ordenar"></i>
              </div>
              <div class="none md-block contenedor_filtrar">
                <span>Filtrar por</span>
                <select  name="campo" class="filtrar">
                  <option @selected($filtros['campo'] == 'aprobadas') value="aprobadas">Aprobadas</option>
                  <option @selected($filtros['campo'] == 'desaprobadas') value="desaprobadas">Desaprobadas</option>
                </select>
                <i class="ti ti-adjustments i_filtrar"></i>
              </div>
                
              <div class="contenedor_filtrado">
                <input name="filtro" class="filtrado-busqueda" value="{{$filtros['filtro']}}" placeholder="Encontrar filtro...">
              </div>
              <div class="contenedor_btn-busqueda">
                <input class="btn-buscador" type="submit" value="Buscar">
              </div>
            </div>
          </form>
        </div>
<div class="table__body">
    <table>
      <thead>
        <tr>
          <th>Materia</th>
          <th>Nota mas alta</th>
          <th>Fecha</th>
        </tr>
      </thead>
      <tbody>
        @foreach($examenes as $examen)
        <tr>
            <td>{{$textFormatService->ucfirst($examen->nombre)}}</td>
            <td>
              @if($examen->aprobado == 3)
                Ausente
              @elseif ($examen->nota < 0.1)
                Por rendir
              @else
                
                {{$examen->nota}}
              @endif
        
            </td>
            <td>
              @php
              $stringDateTime = $examen->fecha;

              // Convertir el string a un objeto DateTime
              $dateObj = new DateTime($stringDateTime);

              // Obtener el día, mes, hora y minutos en formato deseado
              $dia = $dateObj->format('j'); // Día sin ceros iniciales
              $mes = $dateObj->format('n'); // Mes sin ceros iniciales
              $horaMinutos = $dateObj->format('H:i'); // Hora y minutos en formato 24 horas


              // Formatear la fecha y hora en el formato deseado
              $fecha = "$dia/$mes - $horaMinutos"."hs";

          @endphp
              {{-- {{explode(' ',$examen->fecha)[0]}} --}}
              {{$fecha}}
            </td>
        </tr>
    
        @endforeach
      </tbody>
    </table>
</div>
</section>
</main>
@endsection
