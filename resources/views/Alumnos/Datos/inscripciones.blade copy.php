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
          @foreach($materias as $materia)
            
            @php
              $yaAnotado=false; 
              $sinMesas=false;
              
              if(count($materia->mesas) < 1)$sinMesas=true;
              else {
                  foreach($materia->mesas as $mesa){
                      if(in_array($mesa->id, $yaAnotadas)) $yaAnotado=$mesa;
                  }
              }

              $path = $yaAnotado? "alumno.bajarse":"alumno.inscribirse";
              $btnTexto = $yaAnotado? "desinscribirme":"inscribirme"; 
            @endphp

            @if (count($materia->mesas)<1)
              @continue
            @endif              

            <tr>
              <td class="text-center">{{$materia->anio + 1}}</td>
              <td>{{$materia->nombre}}</td>
              <td>
                <p>{{$materia->mesas[0]->profesorNombre('presidente')}}</p>
                <p>{{$materia->mesas[0]->profesorNombre('vocal1')}}</p>
                <p>{{$materia->mesas[0]->profesorNombre('vocal2')}}</p>
              </td>
              @include('Componentes.inscripcion-form')
            @endforeach

          </tbody>
        </table>

      </div>
    </section>
    
  </main>

@endsection
