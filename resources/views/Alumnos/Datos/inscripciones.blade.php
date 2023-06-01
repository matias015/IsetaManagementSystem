@extends('Alumnos.layout')

@section('content')

<main>
    <section class="table">
      <div class="table__header">
        <h1>Inscripciones</h1>
      </div>
      <div class="table__body">
        <table>
          <thead>
            <tr>
              <th>Año</th>
              <th>Materia</th>
              <th>Hora</th>
              <th>Profesores</th>
              <th>Llamado 1</th>
              <th>Llamado 2</th>
              <th>In</th>
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

            <tr>
              <td>{{$materia->anio + 1}}</td>
              <td>{{$materia->nombre}}</td>
              <td>{{$materia->hora}}</td>
              <td>{{$materia->mesas[0]->prof_presidente}}</td>
              
              <td class="llamado_1">
                @dd($materia->mesas)
                @foreach ($materia->mesas as $mesa)
                  <input type="radio">
                  <span>{{$mesa->fecha}}</span>
                @endforeach
              </td>
                  
              
              <td class="llamado_2">
                  <input type="radio">
                  <span>22/3</span>
              </td>
              <td>
                  <button class="boton-finales inscribir">
                      <i class="ti ti-check"></i>
                  </button>
                  <button class="boton-finales bajarse">
                      <i class="ti ti-x"></i>
                  </button>
              </td>
            </tr>

@endforeach

            <tr>
              <td>1</td>
              <td>EDI 1</td>
              <td>18.30</td>
              <td>A confirmar...</td>
              <td class="llamado_1">
                  <input type="radio">
                  <span>15/3</span>
              </td>
              <td class="llamado_2">
                  <input type="radio">
                  <span>22/3</span>
              </td>
              <td>
                  <button class="boton-finales inscribir">
                      <i class="ti ti-check"></i>
                  </button>
                  <button class="boton-finales bajarse">
                      <i class="ti ti-x"></i>
                  </button>
              </td>
            </tr>
            <tr>
              <td>3</td>
              <td>Practicas profesionales</td>
              <td>18.30</td>
              <td>Gonzalez / Armendano</td>
              <td class="llamado_1">
                  <input type="radio">
                  <span>6/3</span>
              </td>
              <td class="llamado_2">
                  <input type="radio">
                  <span>13/3</span>
              </td>
              <td>
                  <button class="boton-finales inscribir">
                      <i class="ti ti-check"></i>
                  </button>
                  <button class="boton-finales bajarse">
                      <i class="ti ti-x"></i>
                  </button>
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>Base de Datos</td>
              <td>18.30</td>
              <td>Nidia Banchero / Luis Secreto</td>
              <td class="llamado_1">
                  <input type="radio">
                  <span>6/3</span>
              </td>
              <td class="llamado_2">
                  <input type="radio">
                  <span>20/3</span>
              </td>
              <td>
                  <button class="boton-finales inscribir">
                      <i class="ti ti-check"></i>
                  </button>
                  <button class="boton-finales bajarse">
                      <i class="ti ti-x"></i>
                  </button>
              </td>
            </tr>
            
            
          </tbody>
        </table>
      </div>

    </section>
    
  </main>
    
</div>
    

@endsection
