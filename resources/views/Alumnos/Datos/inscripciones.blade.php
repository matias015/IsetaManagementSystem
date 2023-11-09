@extends('Alumnos.layout')

@section('content')

<main id="fondo-estudiantes">
  <section class="table">
    <div class="table__header">
      <h1>Inscripciones</h1>
    </div>
    <div class="table__body">
      <table>
        <thead>
          <tr>
            <th class="text-center">Año</th>
            <th>Materia</th>
            <th>Profesores</th>
            <th>Llamado 1</th>
            <th>Llamado 2</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
          @foreach($disponibles as $disponible)
          {{-- @dd($disponible['asignatura']) --}}
          {{-- @dd($disponibles) --}}
            @php
              $asignatura = $disponible['asignatura'];
              $correlativas = $disponible['correlativas'];
              $yaAnotado = $disponible['yaAnotado'];
              $path = $yaAnotado? "alumno.bajarse":"alumno.inscribirse";
              $btnTexto = $yaAnotado? "desinscribirme":"inscribirme"; 
              $btnTexto = $correlativas? "No disponible":$btnTexto;
              if($asignatura->mesas[0]) $key = 0;
              else $key=1;
            @endphp 
            

            <tr>
              <td class="text-center">{{$asignatura->anio}}</td>
              
              <td>{{$asignatura->nombre}}</td>
              <td>
                <p>-> {{$asignatura->mesas[$key]->profesorNombre('presidente')}}</p>
                <p>-> {{$asignatura->mesas[$key]->profesorNombre('vocal1')}}</p>
                @if ($asignatura->mesas[$key]->prof_vocal_2)
                  <p>-> {{$asignatura->mesas[$key]->profesorNombre('vocal2')}}</p>
                @endif  
              </td>
              @include('Componentes.inscripcion-form')
            @endforeach

          </tbody>
        </table>

      </div>
    </section>
    
  </main>

@endsection
