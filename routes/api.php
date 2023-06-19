<?php

use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Carrera;
use App\Models\Correlativa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/a/{carrera}',function(Request $request, $carrera){
    return Asignatura::where('id_carrera',$carrera)->get();
});

Route::get('cursadas/alumnos/{asignatura}',function(Request $request, $asignatura){
  Alumno::all();

});