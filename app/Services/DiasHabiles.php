<?php

namespace App\Services;

use App\Models\DiaNoHabil;
use DateInterval;
use DatePeriod;
use DateTime;

class DiasHabiles{

    static function desdeHoyHasta($fecha){
        
    // fecha de mesa test
    $testStr = $fecha;
    
    // fecha actual y de mesa
    $currentDateTime = new DateTime(); // Obtiene la fecha y hora actual
    $targetDateTime = new DateTime($testStr); // Define la fecha y hora objetivo

    if($currentDateTime>$targetDateTime){
        return 0;
    }

    $fechaActualHoras = $currentDateTime->format('H');
    $fechaActualMinutos = $currentDateTime->format('i');
    $minutosRestantesHoy = (24*60) - ($fechaActualHoras * 60 + $fechaActualMinutos);
    //si la fecha dada es no habil minutosRestantesHoy = 0

    $fechaDadaHoras = $targetDateTime->format('H');
    $fechaDadaMinutos = $targetDateTime->format('i');
    $minutosHastaMesa = $fechaDadaHoras * 60 + $fechaDadaMinutos;
   
    $minutosTotales = $minutosRestantesHoy + $minutosHastaMesa;
    
    if($currentDateTime->format('y-m-d') === $targetDateTime->format('y-m-d')){
        $minutosTotales = $minutosTotales - (24*60);
    }

    // intervalo de dias
    $intervalo = new DateInterval('P1D');
    $targetDateTime = new DateTime($targetDateTime->format('y-m-d'));
    $periodo = new DatePeriod($currentDateTime, $intervalo, $targetDateTime);

    $i = 0;
    $dias = [];
    $festivos = DiasHabiles::obtenerFestivos();
    
    foreach ($periodo as $fecha) {
        $i++;

        if($i==1) continue;
    
        if ($fecha->format('D')=='Sun' || $fecha->format('D')=='Sat') { // Excluir sábados y domingos            
            continue;
        }
        
        if (in_array($fecha->format('Y-m-d'), $festivos)) { 
            
            continue; 
        }

        $minutosTotales = $minutosTotales + 24*60;
        
    }
    return $minutosTotales / 60;

    }
    static function obtenerFestivos() {
        // Aquí puedes agregar o mantener una lista de días festivos para el año dado
        // Los días festivos pueden variar según la ubicación y el año
        // Este es solo un ejemplo de lista ficticia de días festivos
    
        $festivos = [
            '2023-08-18', // Ejemplo: Día festivo
            '2023-08-21', // Ejemplo: Otro día festivo
        ];
    
        return $festivos;
    }

    // static function desdeHoyHasta($hasta){

    //     // feha de hoy
    //     $init = new DateTime(date("Y-m-d"));

    //     // fecha ingresada
    //     $mesa = new DateTime($hasta);

    //     // fecha ingresada en formato yyyy-mm-dd
    //     $mesaString = $mesa->format('Y-m-d');

    //     $noHabiles = DiaNoHabil::select('fecha')-> pluck('fecha') -> toArray();

    //     $dias = 0;
    //     for($i=0;$i<365;$i++){
            
    //         // si llegamos a la fecha pero cae dia feriado o finde retorna -1
    //         if($init->format('Y-m-d') === $mesaString){
    //             if(($init -> format('D') == "Sat" || $init -> format('D') == "Sun") || in_array($init->format('Y-m-d'), $noHabiles) ){
    //                 return -1;
    //             }
    //             break;
    //         }

    //         //si es sabado o feriado no suma
    //         if(($init -> format('D') == "Sat" || $init -> format('D') == "Sun") || in_array($init->format('Y-m-d'), $noHabiles) ){
    //             $init -> modify('+1 day');
    //             continue;
    //         }
            
    //         $dias++;
    //         $init -> modify('+1 day');
    //     }

    //     return $dias;
    // }
}

