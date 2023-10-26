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
        
        @foreach ($asignatura->cursadas as $cursada)
            
            <tr>
                <td></td>
                <td colspan="3">{{$cursada->alumno->apellidoNombre()}}</td>
                <td>{{$cursada->alumno->dni}}</td>
                <td>{{$cursada->condicionString()}}</td>
                <td>{{$cursada->anio_cursada}}</td>
            </tr>
            @endforeach
        @endforeach
    </tbody>

</table>