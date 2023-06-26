    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <style>

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        .acta_contenedor {
            width: 100%;
        }

        .acta_contenedor th {
            text-align: left;
            width: 50%;
        }

        .acta_info-carrera_bottom td {
            text-align: left;
        }

        .tabla1, .tabla2 {
            width: 100%;
        }

        .tabla1 th {
            text-align: center;
        }

        .tabla2 td {
            min-width: 50px;
        }

        .tabla1, .tabla1 th, .tabla1 td, .tabla2, .tabla2 th, .tabla2 td {
        border: 1px solid black;
        border-collapse: collapse;
        }

        td {
            text-align: center;
        }

        </style>
    </head>
    <body>
        <table class="acta_contenedor">
            <thead>
                <tr class="acta_top">
                    <th colspan="2">Provincia de Buenos Aires</th>
                    <th colspan="2">ACTA VOLANTE DE EXÁMENES</th>
                </tr>
                <tr>
                    <th>Dirección General de Cultura y Educación</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td></td>
                <td></td>
                <td>Fecha</td>
                <td>Hora</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>26/5</td>
                <td>18.30</td>
            </tr>
            <tr>
                <td colspan="4">Carrera: {{$mesa->materia->carrera->nombre}}</td>
            </tr>
            <tr class="acta_info-carrera_bottom">
                <td>Año: {{$mesa->materia->anio+1}}</td>
                <td colspan="3">Asignatura: {{$mesa->materia->nombre}}</td>
            </tr>
            <tr>
                <td colspan="4">
                    <table class="tabla1">
                        <thead>
                            <tr>
                                <th rowspan="2">N° Orden</th>
                                <th rowspan="2">Nombre y Apellido</th>
                                <th colspan="3">Calificación</th>
                                <th rowspan="2">N° Documento</th>
                            </tr>
                            <tr>
                                <th>Oral </th>
                                <th>Escrito</th>
                                <th>Prom.</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($alumnos as $alumno)
                            <tr>
                                <td></td>
                                <td>{{$alumno->nombre . ' ' . $alumno->apellido}}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{$alumno->dni}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="acta_info-profesores" colspan="2">
                    <table>
                        <tbody>
                            <tr>
                                <td>Presidente: {{$mesa->prof_presidente != 0? $mesa->profesor->nombre . ' ' . $mesa->profesor->apellido:'A confirmar'}}</td>
                            </tr>
                            <tr>
                                <td>1° Vocal: {{$mesa->prof_vocal_1 != 0?
                        $mesa->vocal1->nombre . ' ' . $mesa->vocal1->apellido:'Sin definir'}}</td>
                            </tr>
                            <tr>
                                <td>2° Vocal: {{$mesa->prof_vocal_2 != 0?
                $mesa->vocal2->nombre . ' ' . $mesa->vocal2->apellido:'Sin definir'}}</td>
                            </tr>
                            <tr>
                                <td>ISETA, 9 de Julio.</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td class="td_tabla2" colspan="2">
                    <table class="tabla2">
                        <tbody>
                            <tr>
                                <td>Total de alumnos:</td>
                                <td></td>
                                </tr>
                            <tr>
                                <td>Aprobados:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Aplazados:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Ausentes:</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            
            
            </tbody>
        </table>
</body>
</html>
