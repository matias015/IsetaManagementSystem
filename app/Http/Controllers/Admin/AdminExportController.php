<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CursadasCarreraExcelExport;
use App\Exports\CursadasExcelExport;
use App\Http\Controllers\Controller;
use App\Models\Asignatura;
use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;


class AdminExportController extends Controller
{
    function cursadasAsignatura(Request $request, Asignatura $asignatura){
        $archivo = \trim($asignatura->nombre).'-cursantes-'.\date('Y-m-d');
        return Excel::download(new CursadasExcelExport($asignatura),$archivo.'.xlsx'); 
    }

    function cursadasCarrera(Request $request, Carrera $carrera){
        $archivo = \trim($carrera->nombre).'-cursantes-'.date('Y-m-d');
        return Excel::download(new CursadasCarreraExcelExport($carrera),$archivo.'.xlsx'); 
    }
    
}
