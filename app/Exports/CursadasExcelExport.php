<?php

namespace App\Exports;

use App\Models\Asignatura;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CursadasExcelExport implements FromView
{
    protected $asignatura;

    public function __construct($asignatura)
    {
        $this->asignatura = $asignatura;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('Admin.Excel.cursadas',[
            'alumnos'=>$this->asignatura->cursantes()
        ]);
    }
}
