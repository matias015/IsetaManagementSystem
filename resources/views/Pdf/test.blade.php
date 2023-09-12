<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Alumnos que cursan {{$asignatura->nombre}}</h1>
    
    <ol>
        @foreach ($alumnos as $alumno)
            <li>{{$alumno->nombre.' '.$alumno->apellido.' - dni: '.$alumno->dni}}</li>
        @endforeach
    </ol>
</body>
</html>