<?php

namespace App\Exports;

use App\Models\Asignatura;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CursadasCarreraExcelExport implements FromView
{ 
    protected $carrera;

    public function __construct($carrera)
    {
        $this->carrera = $carrera;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $asignaturas = Asignatura::where('id_carrera',$this->carrera->id)->get();
        
        return view('Admin.Excel.cursadas-carrera',[
            'asignaturas'=>$asignaturas,
            'carrera'=>$this->carrera
        ]);
    }
}
