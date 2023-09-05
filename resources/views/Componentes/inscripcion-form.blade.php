<form method="POST" action="{{route($path)}}">
    @csrf
      
    @if ($yaAnotado)
        @if($yaAnotado->llamado == 1)
            <td class="llamado_{{$yaAnotado->llamado}}">
                <input checked name="mesa" value="{{$yaAnotado->id}}" type="radio">
                @php
                $stringDateTime = $yaAnotado->fecha;

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
    
            <td class="llamado_{{$yaAnotado->llamado}}">
                -
            </td>
        @else
            <td class="llamado_{{$yaAnotado->llamado}}">
                -
            </td>
            <td class="llamado_{{$yaAnotado->llamado}}">
                <input checked name="mesa" value="{{$yaAnotado->id}}" type="radio">
                @php
                $stringDateTime = $yaAnotado->fecha;

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
        @endif

        @else

       

        <td class="llamado_1">
            <input name="mesa" value="{{$materia->mesas[0]->id}}" type="radio">
            @php
                $stringDateTime = $materia->mesas[0]->fecha;

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
    
        @isset($materia->mesas[1])
            <td class="llamado_2">
            <input name="mesa" value="{{$materia->mesas[1]->id}}" type="radio">
            @php
                $stringDateTime = $materia->mesas[1]->fecha;

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
        @else
            <td class="llamado_2"> - </td>
        @endisset
    @endif

    <td>
        <button @class([
          'boton-finales inscribir' => !$yaAnotado,
          'boton-finales bajarse' => $yaAnotado])>
            {{$btnTexto}}
        </button>
    </td>
  </tr>
  </form>
