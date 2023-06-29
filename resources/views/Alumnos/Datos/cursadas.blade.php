@extends('Alumnos.layout')
@section('content')
<main id="fondo-estudiantes">
          <section class="table">
            <div class="table__header">
          <h1>Mis cursadas </h1>
          {{-- <div class="filtrar"> --}}
              <form action="{{route('alumno.cursadas')}}">
              <div class="tabla_botonera">

                <div class="contenedor_ordenar">
                  <select class="ordenar" name="orden">
                      <option @selected($filtros['orden'] == 'anio') value="anio">Año carrera</option>
                      <option @selected($filtros['orden'] == 'anio_cursada') value="anio_cursada">Año cursada</option>
                  </select>
                  <i class="ti ti-arrows-down-up i_ordenar"></i>
                </div>
                
                <div class="contenedor_filtrar">
                  <select class="filtrar" name="campo">
                      <option value="ninguno">todo</option>
                      <option @selected($filtros['campo'] == 'asignatura') value="asignatura">asignatura</option>
                      <option @selected($filtros['campo'] == 'aprobadas') value="aprobadas">aprobadas</option>
                      <option @selected($filtros['campo'] == 'desaprobadas') value="desaprobadas">desaprobadas</option>
                      <option @selected($filtros['campo'] == 'final_aprobado') value="final_aprobado">final aprobado</option>
                      <option @selected($filtros['campo'] == 'final_desaprobado') value="final_desaprobado">final desaprobado</option>
                    </select>
                    <i class="ti ti-adjustments i_filtrar"></i>
                </div>
                <div class="contenedor_filtrado">
                      <input class="filtrado-busqueda" value="{{$filtros['filtro']}}" name="filtro" type="text">
                      <i class="ti ti-search i_lupa"></i>
                      <i class="ti ti-x i_borrar"></i>
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
                <th>Año cursada</th>
                <th>Final</th>
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
                <td>{{$cursada->asignatura->anio+1}}</td>
                <td>{{$cursada->asignatura->nombre}}</td>
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
                <td>{{$cursada->anio_cursada}}</td>
                @if (in_array($cursada->id_asignatura,$examenesAprobados))
                <td>Aprobado</td>
            @else
                <td>Desprobado / Sin rendir</td>
            @endif
              </tr>
            @endforeach
              
            </tbody>
          </table>
        </div>

      </section>
      </main>

@endsection
