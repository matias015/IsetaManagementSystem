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
                <input name="filtro" class="filtrado-busqueda" value="{{$filtros['filtro']}}" placeholder="Algebra, Ingles, ...">
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
          <th>Fecha - Hora</th>
        </tr>
      </thead>
      <tbody>
        @php
            $actual = "";
            $primero = true;
            $anio_actual = "";
        @endphp
        @foreach($examenes as $key => $examen)
          
          
          @php  
            if ($actual == $examen->id_asignatura) {
              echo '<tr id="td-'.$examen->id_asignatura.'" class="none">';  
            }else{
              echo '<tr>';
            }
          @endphp
        
        @if ($anio_actual != $examen->anio)
                  <tr>
                      <td class="center font-600 tit-year" colspan="3">
                        Año: {{$examen->anio+1}}
                      </td>
                  </tr>
                  @php
                    $anio_actual = $examen->anio
                  @endphp
                @endif

        
          
          
          @if ($actual != $examen->id_asignatura && !$loop->last && $examenes[$key+1]->id_asignatura == $examen->id_asignatura)
            <td class="flex items-center">
              {{$examen->nombre}}
              <button class="btn-mov pointer bg-transparent px-2 mx-5 desplegable" data-element="{{$examen->id_asignatura}}">⇅</button> 
            </td>
          @else
            <td>{{$examen->nombre}}</td>    
          @endif
          @php
            $actual = $examen->id_asignatura;
        @endphp  
          
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
              {{$formatoFecha->d_m_h_m($examen->fecha())}}
            </td>
        </tr>
        
        @endforeach
      </tbody>
    </table>
</div>
</section>
</main>
<script>
  // const button = document.querySelector('#ver-equiv')
  window.onclick = function(e){
    
      if(!e.target.classList.contains('desplegable')) return
      
      let id = e.target.dataset.element
      console.log(document.querySelector('#td-'+id));
      let list = document.querySelector('#td-'+id)
      
      list.classList.toggle('none')
  }
</script>
@endsection
