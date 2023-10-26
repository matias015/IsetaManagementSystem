<br><table>

    <thead>
      <tr>
        <th></th>
        <th colspan="5">{{$asignatura->nombre}}</th>
      </tr>
        
        <tr>
            <th></th>
            <th>Alumno</th>
            <th>Dni</th>
            <th>Condicion</th>
            <th>Año</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($asignatura->cursadas as $cursada)
          <tr>
            <td></td>
            <td colspan="3">{{$cursada->alumno->apellidoNombre()}}</td>
            <td>{{$cursada->alumno->dni}}</td>
            <td>{{$cursada->condicionString()}}</td>
            <td>{{$cursada->anio_cursada}}</td>
          </tr>
        @endforeach
    </tbody>

</table>