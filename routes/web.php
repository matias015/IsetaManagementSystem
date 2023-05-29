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

Route::get('test', function(){
    $pdf = Pdf::loadView('Pdf.test');
    return $pdf->download('invoice.pdf');
});
