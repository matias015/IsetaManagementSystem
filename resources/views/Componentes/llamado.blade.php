<td class="llamado_2">

    <input name="mesa" value="{{$mesa->id}}" type="radio">
    @php
        $stringDateTime = $mesa->fecha;

        // Convertir el string a un objeto DateTime
        $dateObj = new DateTime($stringDateTime);

        // Obtener el día, mes, hora y minutos en formato deseado
        $dia = $dateObj->format('j'); // Día sin ceros iniciales
        $mes = $dateObj->format('n'); // Mes sin ceros iniciales
        $horaMinutos = $dateObj->format('H:i'); // Hora y minutos en formato 24 horas


        // Formatear la fecha y hora en el formato deseado
        $fecha = "$dia/$mes - $horaMinutos"."hs";

    @endphp
    <span>{{$fecha}}</span>
</td>