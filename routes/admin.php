<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AlumnoCrudController;
use App\Http\Controllers\AlumnoAuthController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\MailVerifController;

use Illuminate\Support\Facades\Route;

Route::redirect('/admin','/admin/login');

Route::get('admin/login', [AdminController::class, 'loginView']) -> name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'login']) -> name('admin.login.post');


Route::prefix('admin')->group(function(){
    Route::resource('alumnos', AlumnoCrudController::class);
});