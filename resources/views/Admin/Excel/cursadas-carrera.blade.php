<br>

<table>

    <thead>
      
        <tr>
            <th></th>
            <th colspan="3">Alumno</th>
            <th>Dni</th>
            <th>Condicion</th>
            <th>Año</th>
        </tr>
    </thead>

    <tbody>
      @foreach ($asignaturas as $asignatura)
      <tr></tr>
        <tr>
          <td></td>
          <td colspan="5">{{$asignatura->nombre}}</td>
        </tr>
        
        @foreach ($asignatura->cursantes() as $alumno)
            
            <tr>
                <td></td>
                <td colspan="3">{{($alumno->apellido.' '.$alumno->nombre}}</td>
                <td>{{$alumno->dni}}</td>
                <td>
                    @switch($alumno->condicion)
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
                <td>{{$alumno->anio_cursada}}</td>
            </tr>
            @endforeach
        @endforeach
    </tbody>

</table>