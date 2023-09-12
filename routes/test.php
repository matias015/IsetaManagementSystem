<?php

use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Cursada;
use App\Models\Examen;
use App\Models\Mesa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mockery\CountValidator\Exact;

Route::get('test/{asignatura}', function(Request $request, Asignatura $asignatura){

    $alumnos = [];

    foreach ($request->toPrint as $alumnoId) {
        $alumnos[] = Alumno::find($alumnoId);
    }


    $pdf = Pdf::loadView('pdf.test', ['alumnos' => $alumnos,'asignatura' => $asignatura]);
    return $pdf->stream('invoice.pdf');
    
})->name('test.print-1');

