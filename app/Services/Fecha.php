<?php

namespace App\Services;

use DateTime;

class Fecha{
     function dmahm($fecha){
        if(!$fecha) return "Sin datos de fecha";

        // Convertir el string a un objeto DateTime
        $dateObj = new DateTime($fecha);

        // Obtener el día, mes, hora y minutos en formato deseado
        $dia = $dateObj->format('j'); // Día sin ceros iniciales
        $mes = $dateObj->format('n'); // Mes sin ceros iniciales
        $anio = $dateObj->format('y'); // 

        $horaMinutos = $dateObj->format('H:i').'hs'; // Hora y minutos en formato 24 horas

        if($horaMinutos == "00:00hs"){
          $horaMinutos = 'Desconocido';
        }

        // Formatear la fecha y hora en el formato deseado
        $fecha = "$dia/$mes/$anio - $horaMinutos";
        return $fecha;
    }
    
     function dmhm($fecha){
        if(!$fecha) return "Sin datos de fecha";

        // Convertir el string a un objeto DateTime
        $dateObj = new DateTime($fecha);

        // Obtener el día, mes, hora y minutos en formato deseado
        $dia = $dateObj->format('j'); // Día sin ceros iniciales
        $mes = $dateObj->format('n'); // Mes sin ceros iniciales

        $horaMinutos = $dateObj->format('H:i').'hs'; // Hora y minutos en formato 24 horas

        if($horaMinutos == "00:00hs"){
          $horaMinutos = 'Desconocido';
        }

        // Formatear la fecha y hora en el formato deseado
        $fecha = "$dia/$mes - $horaMinutos";
        return $fecha;
    }

    function dma($fecha){
      if(!$fecha) return "Sin datos de fecha";

      // Convertir el string a un objeto DateTime
      $dateObj = new DateTime($fecha);

      // Obtener el día, mes, hora y minutos en formato deseado
      $dia = $dateObj->format('j'); // Día sin ceros iniciales
      $mes = $dateObj->format('n'); // Mes sin ceros iniciales
      $anio = $dateObj->format('Y'); // 

      // Formatear la fecha y hora en el formato deseado
      $fecha = "$dia/$mes/$anio";
      return $fecha;
  }

  function dm($fecha){
    if(!$fecha) return "Sin datos de fecha";

    // Convertir el string a un objeto DateTime
    $dateObj = new DateTime($fecha);

    // Obtener el día, mes, hora y minutos en formato deseado
    $dia = $dateObj->format('j'); // Día sin ceros iniciales
    $mes = $dateObj->format('n'); // Mes sin ceros iniciales

    // Formatear la fecha y hora en el formato deseado
    $fecha = "$dia/$mes";
    return $fecha;
}
}

