@extends('Alumnos.layout')
@section('content')
<main id="fondo-estudiantes">
          <section class="table">
            <div class="table__header">
          <h1>Mis cursadas </h1>
          {{-- <div class="filtrar"> --}}
              <form class="none md-block" action="{{route('alumno.cursadas')}}">
              <div class="tabla_botonera">

                <div class="contenedor_ordenar">
                  <span>Ordenar por</span>
                  <select class="ordenar" name="orden">
                      <option @selected($filtros['orden'] == 'anio') value="anio">Año carrera</option>
                      <option @selected($filtros['orden'] == 'anio_cursada') value="anio_cursada">Año cursada</option>
                      <option @selected($filtros['orden'] == 'anio_desc') value="anio_desc">Año carrera desc</option>
                      <option @selected($filtros['orden'] == 'anio_cursada_desc') value="anio_cursada_desc">Año cursada desc</option>
                  </select>
                  <i class="ti ti-arrows-down-up i_ordenar"></i>
                </div>
                
                <div class="contenedor_filtrar">
                  <span>Filtrar por</span>
                  <select class="filtrar" name="campo">
                      <option value="ninguno">Ninguno</option>
                      <option @selected($filtros['campo'] == 'aprobadas') value="aprobadas">Aprobadas</option>
                      <option @selected($filtros['campo'] == 'desaprobadas') value="desaprobadas">Desaprobadas</option>
                      <option @selected($filtros['campo'] == 'final_aprobado') value="final_aprobado">Final aprobado</option>
                      <option @selected($filtros['campo'] == 'final_desaprobado') value="final_desaprobado">Final desaprobado</option>
                    </select>
                    <i class="ti ti-adjustments i_filtrar"></i>
                </div>
                <div class="contenedor_filtrado">
                      <input class="filtrado-busqueda" value="{{$filtros['filtro']}}" name="filtro" type="text" placeholder="Algebra, Ingles, ...">
                </div>

                <div class="contenedor_btn-busqueda">
                  <input class="btn-buscador" type="submit" value="Buscar">
                </div>
                
                </div>
            </form>
          
          <!--<label class="switch">
            <input checked="checked" type="checkbox">
            <div class="button">
              <div class="light"></div>
              <div class="dots"></div>
              <div class="characters"></div>
              <div class="shine"></div>
              <div class="shadow"></div>
            </div>
          </label> -->
        </div>
        <div class="table__body">
          <table>
            <thead>
              <tr>
                <th>Materia</th>
                <th>Cursada</th>
                <th class="text-center">Condicion</th>
                <th class="text-center">Año cursada</th>
                <th>Examen final</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody>
              
              @php
                $actual = "";
                $primero = true;
                $anio_actual = "";
              @endphp

              @foreach($cursadas as $key=>$cursada)
                
                @if($filtros['campo'] == 'final_aprobado' && !in_array($cursada->id_asignatura,$examenesAprobados))
                  @continue
                @elseif($filtros['campo'] == 'final_desaprobado' && in_array($cursada->id_asignatura,$examenesAprobados))
                  @continue
                @endif

                @if ($anio_actual != $cursada->anio)
                  <tr>
                      <td class="center font-600" colspan=6>
                        Año: {{$cursada->anio+1}}
                      </td>
                  </tr>
                  @php
                    $anio_actual = $cursada->anio
                  @endphp
                @endif

                @php  
                  if ($actual == $cursada->id_asignatura) {
                    echo '<tr id="td-'.$cursada->id_asignatura.'" class="none">';
                  }else{
                    echo '<tr>';
                  }
                @endphp
              {{-- <tr> --}}

                @if ($actual != $cursada->id_asignatura && !$loop->last && $cursadas[$key+1]->id_asignatura == $cursada->id_asignatura)
                  <td>
                    {{$textFormatService->ucfirst($cursada->nombre)}}
                    <button class="pointer bg-transparent px-2 mx-5 rounded desplegable" data-element="{{$cursada->id_asignatura}}">↓</button> 
                  </td>
                @else
                  <td>{{$textFormatService->ucfirst($cursada->nombre)}}</td>    
                @endif
                @php
                  $actual = $cursada->id_asignatura;
                @endphp  



                <td>
                    <p @class([
                        'status' => true,
                        'aprobada' => $cursada->aprobada == 1,
                        'reprobada' => $cursada->aprobada == 2,
                        'cursando' => $cursada->aprobada == 3
                    ]) >
                    @if($cursada->aprobada == 1)
                        Aprobada
                    @elseif($cursada->aprobada == 2)
                        Reprobada
                    @else
                        En curso
                    @endif
                    </p>
                </td>
                  <td class="text-center">
                  @switch($cursada->condicion)
                    @case(0)
                      Libre
                      @break
                    @case(1)
                      Regular  
                      @break
                    @case(2)
                      Promocion  
                      @break
                    @case(3)
                      Equivalencia  
                      @break
                    @case(4)
                      Desertor
                      @break
                    @default
                        Otro
                    @endswitch
                </td>
                <td class="text-center">{{$cursada->anio_cursada}}</td>
                @if (in_array($cursada->id_asignatura,$examenesAprobados))
                <td>Aprobado</td>
            @else
                <td>Desprobado / Sin rendir</td>
            @endif
            <td>
              @if ($cursada->aprobada == 3)
              <form method="POST" action="{{route('alumno.rematriculacion.delete', ['cursada'=>$cursada->id])}}">
                @csrf
                @method('delete')
                <button class="rounded px-2 py-1 bg-red-400 bajarse2">Bajarse</button>
              </form>    
              @endif
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
