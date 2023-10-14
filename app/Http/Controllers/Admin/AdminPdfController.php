<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Cursada;
use App\Models\Examen;
use App\Models\Mesa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AdminPdfController extends Controller
{
    function acta_volante(Request $request,Mesa $mesa){

        $alumnos = [];

        $examenes = Examen::where('id_mesa', $mesa->id)->get();

        foreach ($examenes as $examen) {
            $cursadas = Cursada::where('id_alumno',$examen->id_alumno)
                -> where('id_asignatura', $examen->id_asignatura)
                -> get();

            foreach ($cursadas as $cursada) {
                if(!$cursada->promocionada){
                    $alumnos[]=Alumno::find($examen->id_alumno);
                }
            }
        }
        // dd($alumnos);
        // $alumnos = Mesa::select('examenes.id as id_examen','alumnos.nombre','alumnos.dni','alumnos.apellido','examenes.nota')
        // -> join('examenes', 'examenes.id_mesa','mesas.id')
        // -> join('alumnos', 'alumnos.id','examenes.id_alumno')
        // -> where('mesas.id', $mesa->id)
        // -> get();



        $pdf = Pdf::loadView('pdf.acta-volante', ['alumnos' => $alumnos,'mesa' => $mesa,'promocion'=>false]);
        return $pdf->stream('invoice.pdf');
    }

    function actaVolantePromocion(Request $request,Mesa $mesa){
        $alumnos = [];

        $examenes = Examen::where('id_mesa', $mesa->id)->get();

        foreach ($examenes as $examen) {
            $cursadas = Cursada::where('id_alumno',$examen->id_alumno)
                -> where('id_asignatura', $examen->id_asignatura)
                -> get();

            foreach ($cursadas as $cursada) {
                if($cursada->promocionada){
                    $alumnos[]=Alumno::find($examen->id_alumno);
                }
            }
        }

        $pdf = Pdf::loadView('pdf.acta-volante', ['alumnos' => $alumnos,'mesa' => $mesa,'promocion'=>true]);
        return $pdf->stream('acta-volante.pdf');
    }
}
