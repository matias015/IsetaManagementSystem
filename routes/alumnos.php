<?php

use App\Http\Controllers\AlumnoAuthController;
use App\Http\Controllers\MailVerifController;
use Illuminate\Support\Facades\Route;

Route::get('alumnos/registro',[AlumnoAuthController::class,'registroView'])->name('alumno.registro');
Route::post('alumnos/registro',[AlumnoAuthController::class,'registro'])->name('alumno.registro.post');

Route::get('alumnos/login',[AlumnoAuthController::class,'loginView'])->name('alumno.login');
Route::post('alumnos/login',[AlumnoAuthController::class,'login'])->name('alumno.login.post');

Route::get('alumno/token', [MailVerifController::class, 'ingresarTokenView'])->name('token.ingreso');
Route::post('alumno/token', [MailVerifController::class, 'verificarToken'])->name('token.ingreso.post');