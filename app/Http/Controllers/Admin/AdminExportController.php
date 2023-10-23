<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CursadasExcelExport;
use App\Http\Controllers\Controller;
use App\Models\Asignatura;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;


class AdminExportController extends Controller
{
    function cursadasAsignatura(Request $request, Asignatura $asignatura){
        return Excel::download(new CursadasExcelExport($asignatura),'a.xlsx'); 
    }
}
