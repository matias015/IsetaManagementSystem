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

        .tabla1 {
            border: 1px solid black;
            border-collapse: collapse;
        }
        

        .tabla1 th, .tabla1 td {
            border: 2.5px solid black;
            border-collapse: collapse;
        }


        .analitico-content, p {
            font-size: 15px;
        }

        .analitico-content span {
            text-transform: uppercase;
        }

        p {
            padding-left: 15px;
        }

        .pos1, .pos2, .pos3 {
            text-transform: uppercase;
        }

        .pos2, .pos3 {
            text-align: center;
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

        .footer-analitico {
            font-size: 12px; 
            text-align: center;
        }

        .pad {
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <table class="acta_contenedor">
        <thead>
            <tr>
                <th><img style="width: 100%" src="{{asset('img/pdf.png')}}" alt=""></th>
            </tr>
        </thead>
        <tbody>
           
           <tr class="analitico-content">
            <td colspan="4">Se deja constancia que {{auth()->user()->apellido}} {{auth()->user()->nombre}} D.N.I: {{auth()->user()->dni}} ha aprobado las siguientes asignaturas correspondientes al plan de estudio de la carrera {{$carrera->nombre}}, resolucion: {{$carrera->resolucion}}
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
                                $aniosTexto = ['SEGUNDO AÑO', 'TERCER AÑO','CUARTO AÑO','QUINTO AÑO', 'SEXTO AÑO', 'SEPTIMO AÑO '];
                                $anio = 0;
                            @endphp

                            @foreach ($materias as $materia)
                            @if ($materia->anio-1 == $anio+1)
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
                                    {{ str_replace('-','/',explode(' ',$materia->examen->fecha)[0]) }}
                                    @else
                                        -----------
                                    @endif
                                </td>
                                <td class="pos3">
                                    @if(isset($materia->examen))
                                        {{$materia->examen->nota}}
                                    @else
                                        -----------
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                       
               
                    </table>
                </td>
            </tr>
            <br>
            <br>
            <p> Porcentaje de materias aprobadas {{$porcentaje}}.</p>

            @php
                $time = time();
                $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
                $mes = $meses[str_replace('','',date("m", $time))-1];
                $dia = str_replace('','',date("d", $time))-1;
                $anio = date("Y", $time);
            @endphp
             
            <p>Se extiende la presente en la ciudad de 9 de Julio a los {{$dia+1}} dias del mes de {{$mes}} de {{$anio}}.</p>
             <br>
            <p class="footer-analitico"> <span>H. Yrigoyen 931 - Tel/Fax (02317) 4225507/422305 - C.P.: 6500 - 9 de Julio (Bs As) Republica Argentina</span>
            <br>
            <b>www.iseta.edu.ar</b>
            <br>
            <span class="pad">dirección@iseta.edu.ar </span>
            <span class="pad">preceptoria@iseta.edu.ar</span>
            <span class="pad">regenciadeinvestigacion@iseta.edu.ar</span>
            </p>
        </tbody>
    </table>
</body>
</html>

