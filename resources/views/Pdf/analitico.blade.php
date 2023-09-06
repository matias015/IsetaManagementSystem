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
            text-align: left;
            width: 50%;
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
                <th>ISETA</th>
                <th>INSTITUTO SUPERIOR EXPERIMENTAL DE TECNOLOGIA ALIMENTARIA</th>
            </tr>
            <tr>
                <th></th>
                <th>Direccion de Educacion Superior</th>
            </tr>
            <tr>
                <th class="th_bor"></th>
                <th class="th_bor">Direccion General de Cultura y Educacion de la Provincia de Buenos Aires</th>
            </tr>
        </thead>
        <tbody>
           //lo que esta entre comillas "", es lo que tenes que rellenar con la magia del php//
            
           <tr>
            <td colspan="4">Se deja constancia que "APELLIDO" "," "NOMBRE" D.N.I: "DNI" ha aprobado las siguientes asignaturas correspondientes al plan de estudio de la carrera {{$carrera}}, resolucion: {{"RESOLUCION"}}
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
                            @foreach ($examenes as $examen) ($as)
        
                            <tr>
                                <td class="pos1">{{$examen->nombre}}</td>
                                <td class="pos2">{{$examen->fecha}}</td>
                                <td class="pos3">{{$examen->nota}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <thead>
                            <tr>
                                <th class="pos1">SEGUNDO AÑO</th>
                                <th class="pos2">FECHA</th>
                                <th class="pos3">CALIFICACION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="pos1">"MATERIA"</td>
                                <td class="pos2">"FECHA"</td>
                                <td class="pos3">"NOTA"</td>
                            </tr>
                        </tbody>
                        <thead>
                            <tr>
                                <th class="pos1">TERCER AÑO</th>
                                <th class="pos2">FECHA</th>
                                <th class="pos3">CALIFICACION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="pos1">"MATERIA"</td>
                                <td class="pos2">"FECHA"</td>
                                <td class="pos3">"NOTA"</td>
                            </tr>
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
