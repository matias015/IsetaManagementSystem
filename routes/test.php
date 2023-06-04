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
    
})->name('test.print-1');


Route::get('llenar-mesas', function(){
    $cursadas = Cursada::where('id_alumno',616)->get();
    foreach($cursadas as $cursada){
        Mesa::create([
            'id_asignatura' => $cursada->id_asignatura,
            'prof_presidente' => 5,
            'prof_vocal_1' => 5,
            'prof_vocal_2' => 5,
            'llamado' => 1,
            'fecha' => '2023-6-12 00:00:00'
        ]);
        Mesa::create([
            'id_asignatura' => $cursada->id_asignatura,
            'prof_presidente' => 5,
            'prof_vocal_1' => 5,
            'prof_vocal_2' => 5,
            'llamado' => 2,
            'fecha' => '2023-6-12 00:00:00'
        ]);
    }
});