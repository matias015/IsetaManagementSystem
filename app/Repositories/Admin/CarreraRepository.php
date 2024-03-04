<?php

namespace App\Repositories\Admin;

use App\Models\Carrera;
use App\Models\Configuracion;


class CarreraRepository{

    public $config;
    public $availableFiels = ['nombre'];

    public function __construct() {
        $this->config = Configuracion::todas();
    }

    function index($request){
        $idsQuery = Carrera::select('carreras.id');

        if($request->has('filter_vigente') && $request->input('filter_vigente') != 0){
            $value = $request->input('filter_vigente');
            $idsQuery->where('carreras.vigente', $value-1);
        }

        if($request->has('filter_search_box') && in_array($request->input('filter_field'),$this->availableFiels)){
            $idsQuery->where($request->input('filter_field'), 'LIKE', '%'.$request->input('filter_search_box').'%');
        }

        $ids = $idsQuery->distinct()->get()->pluck('id');

        $carreras = Carrera::select('carreras.*')->whereIn('carreras.id', $ids)
        ->orderBy('nombre')
        ->paginate($this->config['filas_por_tabla']); 

        
        return $carreras;

    }

}