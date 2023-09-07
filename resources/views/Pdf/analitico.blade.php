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
            font-size: 12px;
        }


        .acta_contenedor {
            width: 100%;
        }


        .acta_contenedor th {
           
            width: 100%;
        }


        .th_bor {
            border-bottom: 1px solid black;
        }


        .tabla1 {
            width: 100%;
        }


        .tabla1, .tabla1 th, .tabla1 td {
            border: 2px solid black;
            border-collapse: collapse;
        }


        .pos1, .pos2, .pos3 {
            text-transform: uppercase;
        }


        .tabla1 th {
            text-align: center;
            font-style: italic;
            font-size: 14px;
        }


        .pos1 {
            width: 450px;
        }


        .pos2 {
            width: 100px;
        }


        .pos3 {
            width: 130px;
        }


    </style>
</head>
<body>
    <table class="acta_contenedor">
        <thead>
            <tr>
                {{-- <th><img style="width: 100%" src="{{asset('img/a.bmp')}}" alt=""></th> --}}
            </tr>
               
        </thead>
        <tbody>
           
           <tr>
            <td colspan="4">Se deja constancia que {{auth()->user()->apellido}} {{auth()->user()->nombre}} D.N.I: {{auth()->user()->dni}} ha aprobado las siguientes asignaturas correspondientes al plan de estudio de la carrera {{$carrera}}, resolucion: {{"RESOLUCION"}}
            </td>
           </tr>
            <tr>
                <td colspan="4">
                    <table class="tabla1">
                        <thead>
                            <tr>
                                <th class="pos1">PRIMER AÑO</th>
                                <th class="pos2">FECHA</th>
                                <th class="pos3">CALIFICACION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $aniosTexto = ['SEGUNDO AÑO', 'TERCER AÑO'];
                                $anio = 0;
                            @endphp


                            @foreach ($materias as $materia)
                            @if ($materia->anio == $anio+1)
                                @php
                                    $anio++;
                                @endphp
                                <thead>
                                    <tr>
                                        <th class="pos1">{{$aniosTexto[$anio-1]}}</th>
                                        <th class="pos2">FECHA</th>
                                        <th class="pos3">CALIFICACION</th>
                                    </tr>
                                </thead>
                            @endif
                            <tr>
                                <td class="pos1">{{$materia->nombre}}</td>
                                <td class="pos2">
                                    @if(isset($materia->examen))
                                        {{$materia->examen->fecha}}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="pos3">
                                    @if(isset($materia->examen))
                                        {{$materia->examen->nota}}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                       
               
                    </table>
                </td>
            </tr>
            <p> Porcentaje de materias aprobadas {{$porcentaje}}.</p>
            <p>Se extiende la presente en la ciudad de 9 de Julio a los {{}} .-</p>
        </tbody>
    </table>
</body>
</html>
