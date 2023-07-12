<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use App\Models\Carrera;
use App\Models\Examen;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\CountValidator\Exact;

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

    function analitico(){
        $alumno = Auth::id();

        $id_carrera = Carrera::getDefault();

        $materias_totales = Asignatura::where('id_carrera', $id_carrera)->count();
        
 
        
        $examenes = Examen::selectRaw('asignaturas.nombre, MAX(examenes.nota) as nota, asignaturas.anio')
        -> from('asignaturas')
        -> join('examenes','examenes.id_asignatura','=','asignaturas.id')
        -> where('examenes.id_alumno', Auth::id())
        -> where('asignaturas.id_carrera', Carrera::getDefault())
        -> where('examenes.nota', '>=', 4)
        -> groupBy('asignaturas.nombre','asignaturas.anio')
        -> get(); 

        $porcentaje = number_format((float) count($examenes) / $materias_totales * 100, 2, '.', ''). '%';

        $pdf = Pdf::loadView('pdf.analitico', [
            'examenes' => $examenes,
            'carrera' => Carrera::where('id',$id_carrera)->first()->nombre,
            'porcentaje' => $porcentaje
        ]);
        return $pdf->stream('invoice.pdf');
    }
}
