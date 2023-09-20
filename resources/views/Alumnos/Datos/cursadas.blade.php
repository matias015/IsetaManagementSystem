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
                      <option @selected($filtros['campo'] == 'aprobadas') value="aprobadas">aprobadas</option>
                      <option @selected($filtros['campo'] == 'desaprobadas') value="desaprobadas">desaprobadas</option>
                      <option @selected($filtros['campo'] == 'final_aprobado') value="final_aprobado">final aprobado</option>
                      <option @selected($filtros['campo'] == 'final_desaprobado') value="final_desaprobado">final desaprobado</option>
                    </select>
                    <i class="ti ti-adjustments i_filtrar"></i>
                </div>
                <div class="contenedor_filtrado">
                      <input class="filtrado-busqueda" value="{{$filtros['filtro']}}" name="filtro" type="text" placeholder="Encontrar filtro...">
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
                <th>Año</th>
                <th>Materia</th>
                <th>Cursada</th>
                <th>Condicion</th>
                <th>Año cursada</th>
                <th>Final</th>
                <th>A</th>
              </tr>
            </thead>
            <tbody>

                @foreach($cursadas as $cursada)
                  @if($filtros['campo'] == 'final_aprobado' && !in_array($cursada->id_asignatura,$examenesAprobados))
                    @continue
                  @elseif($filtros['campo'] == 'final_desaprobado' && in_array($cursada->id_asignatura,$examenesAprobados))
                    @continue
                  @endif
              <tr>
                <td>{{$cursada->anio+1}}</td>
                <td>{{$cursada->nombre}}</td>
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
                  <td>
                  @switch($cursada->condicion)
                    @case(1)
                      libre
                      @break
                    @case(2)
                      Regular  
                      @break
                    @case(3)
                      desertor  
                      @break
                    @case(4)
                      atrasoacadamico  
                      @break
                    @default
                        otro
                    @endswitch
                </td>
                <td>{{$cursada->anio_cursada}}</td>
                @if (in_array($cursada->id_asignatura,$examenesAprobados))
                <td>Aprobado</td>
            @else
                <td>Desprobado / Sin rendir</td>
            @endif
            <td>
              <form method="POST" action="{{route('alumno.rematriculacion.delete', ['cursada'=>$cursada->id])}}">
                @csrf
                @method('delete')
                <button class="rounded px-2 py-1 bg-red-400">Bajarse</button>
              </form>
            </td>
              </tr>
            @endforeach
              
            </tbody>
          </table>
        </div>

      </section>
      </main>

@endsection
