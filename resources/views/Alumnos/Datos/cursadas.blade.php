@extends('Alumnos.layout')
@section('content')
<table>
          <section class="table">
        <div class="table__header">
          <h1>Mis cursadas </h1>
          <div class="tabla_botonera">
            

            {{-- <div class="filtrar"> --}}
              <form action="{{route('alumno.cursadas')}}">
                <p>filtrar</p> 
                <select name="campo">
                    <option value="ninguno">todo</option>
                    <option @selected($filtros['campo'] == 'asignatura') value="asignatura">asignatura</option>
                    <option @selected($filtros['campo'] == 'aprobadas') value="aprobadas">aprobadas</option>
                    <option @selected($filtros['campo'] == 'desaprobadas') value="aprobadas">desaprobadas</option>
                    <option @selected($filtros['campo'] == 'final_aprobado') value="final_aprobado">final aprobado</option>
                    <option @selected($filtros['campo'] == 'final_desaprobado') value="final_desaprobado">final desaprobado</option>
                  </select>
                <input value="{{$filtros['filtro']}}" name="filtro" type="text">
                <p>ordenar</p>
                <select name="orden">
                    <option @selected($filtros['orden'] == 'anio') value="anio">Año carrera</option>
                    <option @selected($filtros['orden'] == 'anio_cursada') value="anio_cursada">Año cursada</option>
                </select>
                <input type="submit" value="Buscar">
            </form>
           
          
            
          </div>
          
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
                <th class="p1">Año</th>
                <th>Materia</th>
                <th>Cursada</th>
                <th class="p2">Año cursada</th>
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
      

@endsection