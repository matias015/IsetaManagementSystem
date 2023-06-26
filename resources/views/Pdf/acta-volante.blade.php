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
        background-color: yellow;
    }
    
    .acta_top {
        display: flex;
        justify-content: space-between;
        background-color: red;
    }

    .acta_info-carrera_bottom {
        display: flex;
        justify-content: space-between;
        background-color: violet;
    }

    .acta_bottom {
        display:inline-block;
        width: 100%;
    }

    .acta_info-profesores {
        width: 60%;
        background-color: green;
    }

    table {
        width: 100%;
    }

    .tabla2 {
        width: 40%;
    }

    .tabla2 td {
        min-width: 50px;
    }

    table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    }

    td {
        text-align: center;
    }

    h1 {
        font-size: 15px;
    }
    </style>
</head>
<body>
    <div class="acta_contenedor">
    <div class="acta_top">
        <span>Provincia de Buenos Aires</span>
        <h1>ACTA VOLANTE DE EXÁMENES</h1>
    </div>
    <div>
    Dirección General de Cultura y Educación
    </div>
    

    <div class="acta_info-carrera">
        <p>Carrera: {{$mesa->materia->carrera->nombre}}</p>
        <div class="acta_info-carrera_bottom">
            <p>Año: {{$mesa->materia->anio+1}}</p>
            <p>asignatura: {{$mesa->materia->nombre}}</p>
        </div>
    </div>

    <table>
    @foreach($alumnos as $alumno)
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
            <tr>
                <td></td>
                <td>{{$alumno->nombre . ' ' . $alumno->apellido}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{$alumno->dni}}</td>
            </tr>
        </tbody>
        @endforeach
    </table>

    <div class="acta_bottom">
        <div class="acta_info-profesores">
            <p>Presidente: {{$mesa->prof_presidente != 0? $mesa->profesor->nombre . ' ' . $mesa->profesor->apellido:'A confirmar'}}</p>
            <p>1° Vocal: {{$mesa->prof_vocal_1 != 0?
                    $mesa->vocal1->nombre . ' ' . $mesa->vocal1->apellido:'Sin definir'}}</p>

            <p>2° Vocal: {{$mesa->prof_vocal_2 != 0?
            $mesa->vocal2->nombre . ' ' . $mesa->vocal2->apellido:'Sin definir'}}</p>
            <span>ISETA, 9 de Julio.</span>
        </div>

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
    </div>
    </div>
    
</body>
</html>
