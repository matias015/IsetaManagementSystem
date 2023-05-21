<?php

use App\Models\Admin;
use App\Models\Alumno;
use App\Models\Carrera;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

include_once("alumnos.php");
include_once("admin.php");

Route::get('test',function(){
    $carreras = Carrera::select('carrera.id', 'carrera.nombre')
        -> join('asignaturas', 'asignaturas.id_carrera', 'carrera.id')
        -> join('cursada', 'cursada.id_asignatura', 'asignaturas.id')
        -> where('cursada.id_alumno', Auth::id()) 
        -> groupBy('carrera.id', 'carrera.nombre')
        -> get();
    
        dd($carreras);
});