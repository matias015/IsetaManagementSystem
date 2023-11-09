<?php

namespace App\Repositories;

use App\Models\Carrera;
use App\Models\Configuracion;
use App\Models\Cursada;
use Illuminate\Support\Facades\Auth;

class AlumnoDataRepository
{
    public $config;

    public function __construct() {
        $this->config = Configuracion::todas();
    }


    function examenes(){}
    
    function cursadas($filtro, $campo, $orden){

        $query = Cursada::with('asignatura')->select('cursadas.id_asignatura','cursadas.anio_cursada','cursadas.id','cursadas.aprobada','cursadas.condicion','asignaturas.nombre','asignaturas.anio')
            -> where('id_alumno', Auth::id())
            -> where('asignaturas.id_carrera', Carrera::getDefault(Auth::id())->id) 
            -> join('asignaturas','asignaturas.id','cursadas.id_asignatura')

            // si tiene un filtro en el campo de texto
            -> when($filtro, fn($query,$filtro) => $query -> where('asignaturas.nombre','LIKE','%'.$filtro.'%'))
            
            // Si se filtra por aprobadas
            -> when($campo == "aprobadas", function($query){
                $query->where(function($sub){
                    $sub -> where('cursadas.aprobada', 1)
                        ->orWhereIn('cursadas.condicion',[0,2,3]);
                });
            })

            // Si se filtra por desaprobadas
            ->when($campo == "desaprobadas", function($query){
                $query-> where('cursadas.aprobada', 2)
                ->whereNotIn('cursadas.condicion',[0,2,3]);
            })

            // Ordenamiento
            -> when($orden == 'anio', fn($query)=>$query->orderBy('asignaturas.anio'))
            -> when($orden == 'anio_cursada', fn($query)=>$query->orderBy('cursadas.anio_cursada'))
            -> when($orden == 'anio_desc', fn($query)=>$query->orderBy('asignaturas.anio','desc'))
            -> when($orden == 'anio_cursada_desc', fn($query)=>$query->orderBy('cursadas.anio_cursada','desc'));

        $query -> orderBy('asignaturas.anio')
        -> orderBy('asignaturas.id')
        -> orderBy('cursadas.anio_cursada','desc');

        return $query->get();
    }
        
    function setCarreraDefault(){}
}