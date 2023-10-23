<br><table>

    <thead>
        <tr>
            <th></th>
            <th>Alumno</th>
            <th>Dni</th>
            <th>Condicion</th>
            <th>Año</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($alumnos as $alumno)
            <tr>
                <td></td>
                <td>{{$textFormatService->ucwords($alumno->apellido.' '.$alumno->nombre)}}</td>
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
    </tbody>

</table>