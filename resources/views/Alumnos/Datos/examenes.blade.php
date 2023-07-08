@extends('Alumnos.layout')

@section('content')
<main id="fondo-estudiantes">
    <section class="table">
<div class="table__header">
          <h1>Examenes</h1>
          <div class="tabla_botonera">
            <div class="none md-block contenedor_filtrar">
              <select class="filtrar">
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
        </div>
<div class="table__body">
    <table>
    <tr>
        <th>Materia</th>
        <th>Nota mas alta</th>
    </tr>
    
    
    @foreach($examenes as $examen)
        <tr>
            <td>{{$textFormatService->utf8Minusculas($examen->nombre)}}</td>
            <td>{{$examen->nota}}</td>
        </tr>
    
    @endforeach
    
    </table>
</div>
</section>
</main>
@endsection

           
  
