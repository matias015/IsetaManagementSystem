<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    <ul>
        @if (count($mesas)<1)
            <h1>No estas inscripto en ningun examen</h1>            
        @endif
        
        @foreach ($mesas as $mesa)
            <li>{{$mesa->asignatura->nombre}}</li>
        @endforeach
    </ul>

</body>
</html>