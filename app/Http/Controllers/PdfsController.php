<?php

namespace App\Http\Controllers;

use App\Models\Examen;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PdfsController extends Controller
{
    function constanciaMesas(){
        $alumno = Auth::id();

        $mesas = Examen::where('id_alumno', $alumno)
            -> join('mesas','mesas.id','examenes.id_mesa')
            -> whereRaw('mesas.fecha >= NOW()')
            -> get();


        $pdf = Pdf::loadView('pdf.constanciaMesas', ['mesas' => $mesas]);
        return $pdf->stream('invoice.pdf');
    }
}
