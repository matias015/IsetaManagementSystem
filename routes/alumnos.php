<?php

use App\Http\Controllers\AlumnoAuthController;
use Illuminate\Support\Facades\Route;

Route::get('alumnos/login',[AlumnoAuthController::class,'loginView']);
Route::post('alumnos/login',function(){

});
