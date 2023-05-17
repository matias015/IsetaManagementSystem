<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlumnoAuthController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\MailVerifController;
use App\Models\Alumno;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('admin/login', [AdminAuthController::class, 'loginView']) -> name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'login']) -> name('admin.login.post');

Route::get('admin/alumnos', [AdminController::class, 'alumnos'])->name('admin.alumnos');