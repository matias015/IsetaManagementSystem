<?php

namespace App\Repositories\Admin;

use App\Models\Configuracion;
use App\Models\Cursada;
use App\Models\Examen;
use App\Models\Mesa;

class MesaRepository
{
    public $config;
    public $availableFiels = [];

    public function __construct() {
        $this->config = Configuracion::todas();
    }

    function index($request){
        $idsQuery = Mesa::select('mesas.id')
            ->join('carreras', 'carreras.id', 'mesas.id_carrera')
            ->join('asignaturas', 'asignaturas.id_carrera', 'carreras.id')
            ->join('examenes','examenes.id_mesa','mesas.id')
            ->join('alumnos', 'alumnos.id', 'examenes.id_alumno');

        if($request->has('filter_carrera_id') && $request->input('filter_carrera_id') != 0){
            $idsQuery->where('mesas.id_carrera', $request->input('filter_carrera_id'));
            if($request->has('filter_asignatura_id') && $request->input('filter_asignatura_id') != 0){
                $idsQuery->where('mesas.id_asignatura', $request->input('filter_asignatura_id'));
            }
        }

        if($request->has('filter_search_box') && in_array($request->input('filter_field'),$this->availableFiels)){
            $idsQuery->where($request->input('filter_field'), 'LIKE', '%'.$request->input('filter_search_box').'%');
        }

        $ids = $idsQuery->distinct()->get()->pluck('id');

        $mesas = Mesa::select('mesas.*')->whereIn('mesas.id', $ids)

        ->paginate($this->config['filas_por_tabla']); 

        
        return $mesas;

    }

    public function inscribibles($mesa){
        $inscribiblesCursada = Cursada::with('alumno')
            -> join('alumnos','cursadas.id_alumno','alumnos.id')
            -> whereRaw('(cursadas.aprobada=1 OR cursadas.condicion=0 OR cursadas.condicion=2 OR cursadas.condicion=3)')
            -> where('cursadas.id_asignatura',$mesa->id_asignatura)
            -> orderBy('alumnos.apellido')
            -> orderBy('alumnos.nombre')
            -> get();

            $inscribibles=[];

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