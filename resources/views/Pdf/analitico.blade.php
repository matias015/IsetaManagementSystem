<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    <h1>Analitico</h1>
    <p>{{$carrera}}</p>
    <table>
        <th>
            <td>Año</td>
            <td>Materia</td>
            <td>Nota</td>
        </th>
        @foreach ($examenes as $examen)
        
        <tr>
            <td>{{$examen->anio + 1}}</td>
            <td>{{$examen->nombre}}</td>
            <td>{{$examen->nota}}</td>
        </tr>
        @endforeach
    </table>

    <h3>{{$porcentaje}} completado</h3>

</body>
</html>