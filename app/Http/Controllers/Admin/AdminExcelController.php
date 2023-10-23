<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asignatura;
use Illuminate\Http\Request;

class AdminExcelController extends Controller
{
    function cursadasAsignatura(Request $request, Asignatura $asignatura){
        return Asignatura::all();
    }
}
