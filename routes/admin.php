<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AlumnoCrudController;

use App\Http\Controllers\Admin\ProfesoresCrudController;
use Illuminate\Support\Facades\Route;

Route::redirect('/admin','/admin/login');



Route::prefix('admin')->group(function(){

    Route::get('login', [AdminAuthController::class, 'loginView']) -> name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login']) -> name('admin.login.post');

    Route::resource('alumnos', AlumnoCrudController::class, ['as' => 'admin']);
    Route::resource('profesores', ProfesoresCrudController::class, [
        'as' => 'admin',
        'parameters' => [
            'profesores' => 'profesor'
        ]
    ]);

});