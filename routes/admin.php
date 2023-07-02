<?php

use App\Http\Controllers\Admin\AdminAuthController;
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

Route::redirect('/admin','/admin/login');



Route::prefix('admin')->group(function(){

    Route::get('/mesas/acta-volante/{mesa}', function(Request $request,Mesa $mesa){
        $alumnos = Mesa::select('examenes.id as id_examen','alumnos.nombre','alumnos.dni','alumnos.apellido','examenes.nota')
        -> join('examenes', 'examenes.id_mesa','mesas.id')
        -> join('alumnos', 'alumnos.id','examenes.id_alumno')
        -> where('mesas.id', $mesa->id)
        -> get();

        $pdf = Pdf::loadView('pdf.acta-volante', ['alumnos' => $alumnos,'mesa' => $mesa]);
        return $pdf->stream('invoice.pdf');
    })->name('admin.mesas.acta');

    Route::get('login', [AdminAuthController::class, 'loginView']) -> name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login']) -> name('admin.login.post');

    Route::resource('alumnos', AlumnoCrudController::class, ['as' => 'admin']);
    Route::resource('egresados', EgresadosAdminController::class, ['as' => 'admin']);

    Route::resource('profesores', ProfesoresCrudController::class, [
        'as' => 'admin', 
        'parameters' => ['profesores' => 'profesor']
    ]);
    
    Route::resource('carreras', CarrerasCrudController::class, ['as' => 'admin']);
    
    Route::resource('asignaturas', AsignaturasCrudController::class, ['as' => 'admin']);

    Route::get('cursadas', [CursadasAdminController::class,'index'])->name('admin.cursadas.index');
    Route::get('cursadas/{cursada}/edit', [CursadasAdminController::class,'edit'])->name('admin.cursadas.edit');
    Route::put('cursadas/{cursada}/edit', [CursadasAdminController::class,'update'])->name('admin.cursadas.update');
    Route::delete('cursadas/{cursada}', [CursadasAdminController::class,'delete'])->name('admin.cursadas.destroy');
    Route::get('cursadas/create', [CursadasAdminController::class,'create'])->name('admin.cursadas.create');
    Route::post('cursadas/create', [CursadasAdminController::class,'store'])->name('admin.cursadas.store');
    

    Route::resource('mesas', MesasCrudController::class, ['as' => 'admin']);
    Route::resource('admins', AdminsCrudController::class, ['as' => 'admin']);

    Route::resource('examenes',ExamenesCrudController::class,[
        'as' => 'admin',
        'parameters' => ['examenes' => 'examen']
    ]);

    //Route::resource('dias', CarrerasCrudController::class, ['as' => 'admin']);
    //Route::resource('cursadas', CarrerasCrudController::class, ['as' => 'admin']);
    //Route::resource('correlativas', CarrerasCrudController::class, ['as' => 'admin']);
    //Route::resource('administradores', CarrerasCrudController::class, ['as' => 'admin']);


    Route::get('config', [ConfigController::class, 'index'])->name('admin.config.index');
    Route::get('config/{clave}', [ConfigController::class, 'setear'])->name('admin.config.set');

});
