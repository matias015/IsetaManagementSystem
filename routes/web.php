<?php

use App\Models\Examen;
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

Route::redirect('/', 'alumno/inscripciones');


include_once("alumnos.php");
include_once("admin.php");
include_once("profesores.php");
include_once("test.php");

Route::fallback(function(){
    return view('Error/404');
});
