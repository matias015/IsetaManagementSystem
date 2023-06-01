<?php

use App\Models\Alumno;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('test', function(Request $request){
    $data = Alumno::findMany($request->toPrint);
    $pdf = Pdf::loadView('Pdf.test-alumnos',['alumnos' => $data]);
    return $pdf->stream('alumnos.pdf');
})->name('test.print-1');