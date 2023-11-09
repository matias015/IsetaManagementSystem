<?php

namespace App\Repositories;

use App\Models\Configuracion;
use App\Models\Cursada;

class CursadaRepository
{
    public function __construct() {
        // $this->var = $var;
    }

    public function conFiltros($filtro, $campo, $orden){

        $porPagina = Configuracion::get('filas_por_tabla',true);
        $query = Cursada::select('alumnos.apellido as alumno_apellido','alumnos.nombre as alumno_nombre','cursadas.id','asignaturas.nombre as asignatura','cursadas.aprobada')
            -> join('asignaturas','asignaturas.id','=','cursadas.id_asignatura')
            -> join('carreras','carreras.id','=','asignaturas.id_carrera')
            -> join('alumnos','alumnos.id','=','cursadas.id_alumno');

        
        if($campo == "asignatura"){
            $query = $query->where('asignaturas.nombre','LIKE','%'.$filtro.'%'); 
        }
        
        else if($campo == "carrera"){
            $query = $query->where('carreras.nombre','LIKE','%'.$filtro.'%'); 
        }

        
        if($filtro){
            if(strpos($filtro,':')){
                $array = explode(':', $filtro);

                $alumno_data = '%'.str_replace(' ','%',$array[1]).'%';
                $asig_nombre = '%'.str_replace(' ','%',$array[0]).'%';
                
                $query->where(function($sub) use($alumno_data,$asig_nombre){
                    $sub->whereRaw("asignaturas.nombre LIKE '$asig_nombre'")
                        ->whereRaw("(CONCAT(alumnos.nombre,' ',alumnos.apellido) LIKE '$alumno_data' OR alumnos.dni LIKE '$alumno_data' OR alumnos.email LIKE '$alumno_data' )");
                });
                $query->orderBy('carreras.nombre');
            }else{
                $word = '%'.str_replace(' ','%',$filtro).'%';
                $query->where(function($sub) use($word){
                    $sub->whereRaw("(asignaturas.nombre LIKE '$word' OR CONCAT(alumnos.nombre,' ',alumnos.apellido) LIKE '$word')");
                });
                $query->orderBy('carreras.nombre');
            }
        }

        if($orden == "creacion"){
            $query->orderBy('cursadas.id','desc');
        }
        else if($orden == "asignatura"){
            $query->orderBy('asignaturas.nombre');
        }

        $cursadas = $query -> paginate($porPagina);
        return $cursadas;
    }
}