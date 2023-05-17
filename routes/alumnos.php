<?php

use App\Http\Controllers\AlumnoAuthController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\MailVerifController;
use App\Models\Alumno;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('alumno/registro',[AlumnoAuthController::class,'registroView'])->name('alumno.registro');
Route::post('alumno/registro',[AlumnoAuthController::class,'registro'])->name('alumno.registro.post');

Route::get('alumno/login',[AlumnoAuthController::class,'loginView'])->name('alumno.login');
Route::post('alumno/login',[AlumnoAuthController::class,'login'])->name('alumno.login.post');

Route::get('alumno/logout',[AlumnoAuthController::class,'logout'])->name('alumno.logout');

Route::get('/alumno/mail', [MailVerifController::class,'enviarMail'])->name('token.enviar.mail');

Route::get('alumno/token', [MailVerifController::class, 'ingresarTokenView'])->name('token.ingreso');
Route::post('alumno/token', [MailVerifController::class, 'verificarToken'])->name('token.ingreso.post');

Route::get('alumno/info', [AlumnoController::class, 'info'])->name('alumno.info');