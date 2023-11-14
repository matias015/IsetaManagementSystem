<?php

namespace App\Repositories;

use App\Models\Configuracion;
use App\Models\Cursada;
use App\Models\Examen;
use App\Models\Mesa;

class MesaRepository
{
    public function __construct() {
        // $this->var = $var;
    }

    public function conFiltros($filtro, $campo, $orden){
        $porPagina = Configuracion::get('filas_por_tabla',true);

        $query = Mesa::select('mesas.hora','mesas.id_asignatura','mesas.id','mesas.llamado','mesas.fecha', 'asignaturas.nombre','asignaturas.anio', 'carreras.nombre as carrera')
            -> join('asignaturas','asignaturas.id','=','mesas.id_asignatura')
            -> join('carreras','carreras.id','=','asignaturas.id_carrera');



        if($campo == "proximas"){
            $query = $query->whereRaw('fecha > NOW()');
        }

        if($orden == "fecha"){
            $query->orderByDesc('mesas.fecha');
        }
        else if($orden == "asignatura"){
            $query->orderBy('asignaturas.nombre');
        }

        if($filtro){
            if(strpos($filtro,':')){
                $array = explode(':', $filtro);
                $carrera_nombre = $array[0];
                $asig_nombre = $array[1];

                $carrera_nombre = '%'.str_replace(' ','%',$array[0]).'%';
                $asig_nombre = '%'.str_replace(' ','%',$array[1]).'%';
                
                $query->where(function($sub) use($carrera_nombre,$asig_nombre){
                    $sub->whereRaw("(asignaturas.nombre LIKE '$asig_nombre' AND carreras.nombre LIKE '$carrera_nombre')");
                });
                $query->orderBy('carreras.nombre');
            }else{
                $word = '%'.str_replace(' ','%',$filtro).'%';
                $query->where(function($sub) use($word){
                    $sub->whereRaw("(asignaturas.nombre LIKE '$word' OR carreras.nombre LIKE '$word')");
                });
                $query->orderBy('carreras.nombre');
            }
        }

        
        $query -> orderBy('mesas.fecha');

        return $query -> paginate($porPagina);
    }

    public function inscribibles($mesa){
        $inscribiblesCursada = Cursada::with('alumno')
            -> join('alumnos','cursadas.id_alumno','alumnos.id')
            -> whereRaw('(cursadas.aprobada=1 OR cursadas.condicion=0 OR cursadas.condicion=2 OR cursadas.condicion=3)')
            -> where('cursadas.id_asignatura',$mesa->id_asignatura)
            -> orderBy('alumnos.apellido')
            -> orderBy('alumnos.nombre')
            -> get();

        foreach ($inscribiblesCursada as $cursada) {
            $alumno = $cursada->alumno;

            $examen = Examen::where('id_alumno', $alumno->id)
                ->where(function($query) use($mesa){
                    $query->where('nota','>=',4)
                        ->orWhere('id_mesa', $mesa->id);
                })
                ->where('id_asignatura', $mesa->id_asignatura)
                ->first();
            
            if(!$examen){
                $inscribibles[]=$alumno;
            }
        }
        return $inscribibles;
    }

    public function delete($mesa){
        Examen::where('id_mesa',$mesa->id)->where('nota',0)->delete();
        $mesa->delete();
    }
}