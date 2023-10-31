<?php

use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Carrera;
use App\Models\Cursada;
use App\Models\Examen;
use App\Models\Mesa;
use App\Models\Profesor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mockery\CountValidator\Exact;

Route::get('test/{asignatura}', function(Request $request,Asignatura $asignatura){
    $siguiente = null;
    $asignaturas = $asignatura->carrera->asignaturas;
    $anterior = null;

    foreach ($asignaturas as $key=>$asig) {
        if($asig->id == $asignatura->id){
            $siguiente = $key+1;
            $anterior = $key-1;
        }
    }

    return view('Admin.Mesas.create-dual', [
        'asignatura' => $asignatura,
        'siguiente' => $siguiente<count($asignaturas)? $asignaturas[$siguiente]:null,
        'anterior' => $anterior>=0? $asignaturas[$anterior]:null,
        'profesores' => Profesor::orderBy('apellido','asc')->orderBy('apellido','asc')->get()
    ]);
})->name('admin.mesas.dual');

Route::post('test/{asignatura}', function(Request $request, Asignatura $asignatura){


    if($request->input('fecha1')){
        Mesa::create([
            'id_asignatura' => $asignatura->id,
            'llamado' => 1,
            'id_carrera' => $asignatura->carrera->id,
            'fecha' => $request->input('fecha1'),
            'prof_presidente' => $request->input('prof_presidente'),
            'prof_vocal_1' => $request->input('prof_vocal_1'),
            'prof_vocal_2' => $request->input('prof_vocal_2')
        ]);
    }

    if($request->input('fecha2')){

        Mesa::create([
            'id_asignatura' => $asignatura->id,
            'llamado' => 2,
            'id_carrera' => $asignatura->carrera->id,
            'fecha' => $request->input('fecha2'),
            'prof_presidente' => $request->input('prof_presidente'),
            'prof_vocal_1' => $request->input('prof_vocal_1'),
            'prof_vocal_2' => $request->input('prof_vocal_2')
        ]);
    }

    // dd([$mesa1,$mesa2]);

    return redirect()->back()->with('Se crearon correctamente');

})->name('admin.mesas.dual');

