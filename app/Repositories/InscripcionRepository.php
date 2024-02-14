<?php

namespace App\Repositories;

use App\Models\Asignatura;
use App\Models\Carrera;
use App\Models\Correlativa;
use App\Models\Examen;
use Illuminate\Support\Facades\Auth;

class InscripcionRepository
{
    public function __construct() {
        // $this->var = $var;
    }

    public function crearInscripcion($mesa, $alumno){
        Examen::create([
            'id_mesa' => $mesa->id,
            'id_alumno'  => $alumno->id,
            'nota'=>'0.00',
            'id_asignatura' => $mesa->id_asignatura,
            'fecha' => \now()
        ]);
    }

    public function borrar($examen){
        $examen->delete();
    }


    public function inscribibles($alumno){
        $asignaturas = Asignatura::with('mesas.anotado')
        -> where('id_carrera', Carrera::getDefault()->id)
        -> get();

    $examenesInscriptos = Examen::select('id_mesa')
        -> where('id_alumno', $alumno->id)
        -> get() -> pluck('id_mesa') -> toArray();

    $posibles = [];
    $reg = [];

    foreach ($asignaturas as $key=>$asignatura) {
        $reg = [
            'asignatura' => null,
            'correlativas' => null,
            'yaAnotado' => null,
        ];
        
        if(count($asignatura->mesas) == 0) continue;
        if($asignatura->aproboExamen(Auth::user())) continue;
        if(!$asignatura->aproboCursada(Auth::user())) continue;

        $reg['asignatura'] = $asignatura;

        foreach($asignatura->mesas as $mesa){      
            if(in_array($mesa->id, $examenesInscriptos)) {
                $reg['yaAnotado'] = $mesa; break;
            }
        }

        $correlativas = Correlativa::debeExamenesCorrelativos($asignatura);
       
        if($correlativas){
            $reg['correlativas'] = $correlativas;
        }
        $posibles[] = $reg;
    }

    return $posibles;
    }
}