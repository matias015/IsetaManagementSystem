<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AlumnoCrudController;
use App\Http\Controllers\Admin\AsignaturasCrudController;
use App\Http\Controllers\Admin\CarrerasCrudController;
use App\Http\Controllers\Admin\MesasCrudController;
use App\Http\Controllers\Admin\ProfesoresCrudController;
use App\Http\Controllers\CursadasAdminController;
use Illuminate\Support\Facades\Route;

Route::redirect('/admin','/admin/login');



Route::prefix('admin')->group(function(){

    Route::get('login', [AdminAuthController::class, 'loginView']) -> name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login']) -> name('admin.login.post');

    Route::resource('alumnos', AlumnoCrudController::class, ['as' => 'admin']);
    
    Route::resource('profesores', ProfesoresCrudController::class, [
        'as' => 'admin', 
        'parameters' => ['profesores' => 'profesor']
    ]);
    
    Route::resource('carreras', CarrerasCrudController::class, ['as' => 'admin']);
    
    Route::resource('asignaturas', AsignaturasCrudController::class, ['as' => 'admin']);

    Route::get('cursadas/{asignatura}/alumno/{alumno}/edit', [CursadasAdminController::class,'edit'])->name('admin.cursadas.edit');
    Route::put('cursadas/{cursada}/edit', [CursadasAdminController::class,'update'])->name('admin.cursadas.update');
    Route::delete('cursadas/{cursada}', [CursadasAdminController::class,'delete'])->name('admin.cursadas.destroy');
    Route::post('cursadas/create', [CursadasAdminController::class,'store'])->name('admin.cursadas.store');
    
    Route::resource('mesas', MesasCrudController::class, ['as' => 'admin']);
    //Route::resource('dias', CarrerasCrudController::class, ['as' => 'admin']);
    //Route::resource('cursadas', CarrerasCrudController::class, ['as' => 'admin']);
    //Route::resource('correlativas', CarrerasCrudController::class, ['as' => 'admin']);
    //Route::resource('administradores', CarrerasCrudController::class, ['as' => 'admin']);

});