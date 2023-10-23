<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminCorrelativasController;
use App\Http\Controllers\Admin\AdminDiasHabilesController;
use App\Http\Controllers\Admin\AdminExcelController;
use App\Http\Controllers\Admin\AdminExportController;
use App\Http\Controllers\Admin\AdminMatriculacionController;
use App\Http\Controllers\Admin\AdminMesaPorCarreraController;
use App\Http\Controllers\Admin\AdminPdfController;
use App\Http\Controllers\Admin\AlumnoCrudController;
use App\Http\Controllers\Admin\AsignaturasCrudController;
use App\Http\Controllers\Admin\CarrerasCrudController;
use App\Http\Controllers\Admin\MesasCrudController;
use App\Http\Controllers\Admin\ProfesoresCrudController;
use App\Http\Controllers\Admin\AdminsCrudController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\ExamenesCrudController;
use App\Http\Controllers\Admin\CursadasAdminController;
use App\Http\Controllers\Admin\EgresadosAdminController;
use App\Models\Mesa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



/* --------------------------------------------------------
 | 
 | original -> 
 | tambien activar middlewares en el controlador
 |
 | NO LOGIN NECESARIO
 | 
 / Route::redirect('/admin','/admin/alumnos'); /*
 |
 |  SOLO POR TESTEO
 | --------------------------------------------------------*/ 

 Route::redirect('/admin','/admin/login');
 Route::middleware(['web'])->prefix('admin')->group(function(){

    Route::get('/mesas/acta-volante/{mesa}', [AdminPdfController::class,'acta_volante'])->name('admin.mesas.acta');
    Route::get('/mesas/acta-volante-prom/{mesa}', [AdminPdfController::class,'actaVolantePromocion'])->name('admin.mesas.actaprom');

    Route::get('/mesas/actas',function(){
        $mesas = Mesa::whereDate('fecha', '>=', now()->subDay()->toDateString())->get();
        dd($mesas);
    })->name('admin.mesas.actas');


    Route::get('login', [AdminAuthController::class, 'loginView']) -> name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login']) -> name('admin.login.post');

    Route::get('logout', [AdminAuthController::class, 'logout']) -> name('admin.logout');

    Route::resource('alumnos', AlumnoCrudController::class, ['as' => 'admin'])->middleware('auth:admin');
    Route::resource('inscriptos', EgresadosAdminController::class, ['as' => 'admin']);

    Route::resource('profesores', ProfesoresCrudController::class, [
        'as' => 'admin', 
        'parameters' => ['profesores' => 'profesor']
    ]);
    
    Route::resource('carreras', CarrerasCrudController::class, ['as' => 'admin'])->middleware('auth:admin');
    
    Route::resource('asignaturas', AsignaturasCrudController::class, ['as' => 'admin']);

    Route::get('cursadas', [CursadasAdminController::class,'index'])->name('admin.cursadas.index');
    Route::get('cursadas/{cursada}/edit', [CursadasAdminController::class,'edit'])->name('admin.cursadas.edit');
    Route::put('cursadas/{cursada}/edit', [CursadasAdminController::class,'update'])->name('admin.cursadas.update');
    Route::delete('cursadas/{cursada}', [CursadasAdminController::class,'delete'])->name('admin.cursadas.destroy');
    Route::get('cursadas/create', [CursadasAdminController::class,'create'])->name('admin.cursadas.create');
    Route::post('cursadas/create', [CursadasAdminController::class,'store'])->name('admin.cursadas.store');
    

    Route::resource('mesas', MesasCrudController::class, ['as' => 'admin'])->middleware('auth:admin');;
    Route::resource('admins', AdminsCrudController::class, ['as' => 'admin']);

    Route::resource('examenes',ExamenesCrudController::class,[
        'as' => 'admin',
        'parameters' => ['examenes' => 'examen']
    ]);


    Route::get('config', [ConfigController::class, 'index'])->name('admin.config.index');
    Route::post('config', [ConfigController::class, 'setear'])->name('admin.config.set');

    Route::post('correlativa/{asignatura}',[AdminCorrelativasController::class, 'agregar'])->name('correlativa.agregar');

    Route::delete('correlativa/{asignatura}',[AdminCorrelativasController::class, 'eliminar'])->name('correlativa.eliminar');


    Route::get('dias-habiles', [AdminDiasHabilesController::class,'index'])->name('admin.habiles.index');
    Route::post('dias-habiles', [AdminDiasHabilesController::class,'store'])->name('admin.habiles.store');
    Route::delete('dias-habiles/{habil}', [AdminDiasHabilesController::class,'destroy'])->name('admin.habiles.destroy');

    Route::get('matricular/{alumno}',[AdminMatriculacionController::class,'rematriculacion_vista'])->name('admin.alumno.rematricular');
    Route::post('matricular/{alumno}/{carrera}',[AdminMatriculacionController::class,'rematriculacion'])->name('admin.alumno.matricular.post');

    Route::get('cursantes/{asignatura}',[AdminExportController::class, 'cursadasAsignatura'])->name('excel.cursadas.asig');
});
