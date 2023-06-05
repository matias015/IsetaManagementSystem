@extends('Alumnos.layout')
@section('content')
<table>
          <section class="table">
        <div class="table__header">
          <h1>Mis cursadas </h1>
          <div class="tabla_botonera">
            

            {{-- <div class="filtrar"> --}}
              <form action="{{route('alumno.cursadas')}}">
                <select name="campo" class="dropdown">
                  <option @selected($filtros['campo'] == 'anio') value="anio" selected><i class="ti ti-123"></i>Año</option>
                  <option @selected($filtros['campo'] == 'materia') value="materia"><i class="ti ti-school"></i>Materia</option>
                  <option @selected($filtros['campo'] == 'anio_carrera') value="anio_carrera"><i class="ti ti-calendar-time"></i>Año carrera</option>
                </select>
                <input value="{{$filtros['filtro']}}" name="filtro">
              </form>
            {{-- </div> --}}
            <div class="descargar">
              <input type="text" class="textDow" placeholder="Descargar" readonly>
              <div class="opciones">
                <div onclick="show('PDF')"><i class="ti ti-pdf"></i>PDF</div>
                <div onclick="show('DOCS')"><i class="fa-solid fa-file-pdf"></i>DOCS</div>
                <div onclick="show('EXCEL')"><i class="ti ti-status-change"></i>EXCEL</div>
                <div onclick="show('PNG')"><i class="ti ti-png"></i>PNG</div>
              </div>
            </div>
            
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