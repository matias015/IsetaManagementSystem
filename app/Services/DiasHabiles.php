<?php

namespace App\Services;

use App\Models\DiaNoHabil;
use DateInterval;
use DatePeriod;
use DateTime;

class DiasHabiles{

    static function desdeHoyHasta($fecha){
        $hoy = new DateTime(date('Y-m-d'));
    $fechaDadaObj = new DateTime(date('Y-m-d', strtotime($fecha)));
    $diferencia = $fechaDadaObj->diff($hoy);
    $dias = $diferencia->days;

    if ($fechaDadaObj > $hoy) {
        $dias = -$dias;
    }

    $intervalo = new DateInterval('P1D');
    $periodo = new DatePeriod($hoy, $intervalo, $fechaDadaObj);

    $diasExcluidos = 0; // Contador de días excluidos (sábados, domingos y festivos)

    foreach ($periodo as $fecha) {
        if ($fecha->format('N')==5 || $fecha->format('N')==6) { // Excluir sábados y domingos
            $diasExcluidos++;
        } else {
            $festivos = DiasHabiles::obtenerFestivos($fecha->format('Y'));
            if (in_array($fecha->format('Y-m-d'), $festivos)) { // Excluir días festivos
                $diasExcluidos++;
            }
        }
    }


    return (($dias*-1) - $diasExcluidos);
    }
    static function obtenerFestivos($anio) {
        // Aquí puedes agregar o mantener una lista de días festivos para el año dado
        // Los días festivos pueden variar según la ubicación y el año
        // Este es solo un ejemplo de lista ficticia de días festivos
    
        $festivos = [
            '2025-06-23', // Ejemplo: Día festivo
            '2026-07-05', // Ejemplo: Otro día festivo
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