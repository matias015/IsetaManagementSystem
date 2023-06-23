<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Acta volante de examenes</h1>

    <p>Carrera: {{$mesa->materia->carrera->nombre}}</p>
    <p>Año: {{$mesa->materia->anio+1}}</p>
    <p>asignatura: {{$mesa->materia->nombre}}</p>
    
    <ul>
        @foreach($alumnos as $alumno)
            <li>Alumno: {{$alumno->nombre . ' ' . $alumno->apellido}}</li>
            <li>Dni: {{$alumno->dni}}</li>
        @endforeach
    </ul>

    <p>Presidente: {{$mesa->prof_presidente != 0? $mesa->profesor->nombre . ' ' . $mesa->profesor->apellido:'A confirmar'}}</p>
    <p>Vocal 1: {{$mesa->prof_vocal_1 != 0?
                    $mesa->vocal1->nombre . ' ' . $mesa->vocal1->apellido:'Sin definir'}}</p>

    <p>Vocal 2: {{$mesa->prof_vocal_2 != 0?
        $mesa->vocal2->nombre . ' ' . $mesa->vocal2->apellido:'Sin definir'}}</p>
</body>
</html>