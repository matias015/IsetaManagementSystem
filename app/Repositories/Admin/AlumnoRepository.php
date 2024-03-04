<?php

namespace App\Repositories\Admin;

use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\Configuracion;
use Illuminate\Support\Facades\DB;

class AlumnoRepository{

    public $config;

    public function __construct() {
        $this->config = Configuracion::todas();
    }

    function index($request){
        $idsQuery = Alumno::select('alumnos.id')
        ->join('egresadoinscripto', 'egresadoinscripto.id_alumno', '=', 'alumnos.id')
        ->join('carreras','carreras.id', '=', 'egresadoinscripto.id_carrera'); 

        if($request->has('filter_carrera_id') && $request->input('filter_carrera_id') != 0){
            $idsQuery->where('egresadoinscripto.id_carrera', $request->input('filter_carrera_id'));
        }

        if($request->has('filter_search_box')){
            if($request->input('filter_field') == 'alumno'){
                $word = str_replace(' ','%',$request->input('filter_search_box'));
                $idsQuery->whereRaw("(CONCAT(alumnos.nombre,' ',alumnos.apellido) LIKE '%$word%')");
            }else{  
                $idsQuery->where($request->input('filter_field'), 'LIKE', '%'.$request->input('filter_search_box').'%');
            }
            
        }

        $ids = $idsQuery->distinct()->get()->pluck('id');

        $alumnos = Alumno::select('alumnos.*')->whereIn('alumnos.id', $ids)
        ->orderBy('nombre')
        ->orderBy('apellido')
        ->paginate($this->config['filas_por_tabla']); 

        
        return $alumnos;

    }

}