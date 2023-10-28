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

Route::get('test', function(Request $request){

    $a=Alumno::inscribibles2();
    return view('Alumnos.Datos.inscripciones2',['disponibles'=>Alumno::inscribibles2()]);
    
})->name('test.print-1');

