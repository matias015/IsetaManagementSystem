@extends('Alumnos.layout')

@section('content')
<main id="fondo-estudiantes">
    <section class="table">
<div class="table__header">
          <h1>Examenes</h1>
          <p>Promedio: {{$promedio}}</p>
          <form class="none md-block" action="{{route('alumno.examenes')}}">
            <div class="tabla_botonera">
              <div class="none md-block contenedor_filtrar">
                <select  name="campo" class="filtrar">
                  <option>Filtrar</option>
                  <option>Año</option>
                  <option>Materia</option>
                  <option>Nota final</option>
                  <option>Fecha final</option>
                </select>
                <i class="ti ti-adjustments i_filtrar"></i>
              </div>
                
              <div class="contenedor_filtrado">
                <input class="filtrado-busqueda">
                <i class="ti ti-search i_lupa"></i>
                <i class="ti ti-x i_borrar"></i>
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
          <th>Fecha final</th>
        </tr>
      </thead>
      <tbody>
        @foreach($examenes as $examen)
        <tr>
            <td>{{$examen->id}}{{$textFormatService->utf8Minusculas($examen->nombre)}}</td>
            <td>{{$examen->nota}}</td>
            <td>{{$examen->fecha}}</td>
        </tr>
    
        @endforeach
      </tbody>
    </table>
</div>
</section>
</main>
@endsection
