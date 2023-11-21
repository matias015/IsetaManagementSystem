<?php


use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Carrera;
use App\Models\Cursada;
use App\Models\Examen;
use App\Models\Mesa;
use App\Models\Profesor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Mockery\CountValidator\Exact;

Route::middleware(['web','auth:admin'])->prefix('admin')->group(function(){







// /////////////////////////////////////////////
Route::get('cursadas/{asignatura}', function(Request $request, Asignatura $asignatura){
    $siguiente = null;
    $asignaturas = $asignatura->carrera->asignaturas;
    $anterior = null;
    
    foreach ($asignaturas as $key=>$asig) {
      if($asig->id == $asignatura->id){
        $siguiente = $key+1;
        $anterior = $key-1;
      }
    }
    
    
    return view('Admin.Cursadas.edit-masivo', [
      'asignatura' => $asignatura,
      'siguiente' => $siguiente<count($asignaturas)? $asignaturas[$siguiente]:null,
      'anterior' => $anterior>=0? $asignaturas[$anterior]:null,
      'carreras' => Carrera::vigentes()
    ]);
})->name('admin.cursadas.masivo');




Route::post('masivo/cursadas', function(Request $request){
    $data = $request->except('_token');

    foreach($data as $idCursada => $condicion){
      $cursada = Cursada::find($idCursada);
     
      if($condicion=='rc'){
        $cursada->condicion = 1;
        $cursada->aprobada = 3;
      }else if($condicion=='rd'){
        $cursada->condicion = 1;
        $cursada->aprobada = 2;
      }else if($condicion=='ra'){
        $cursada->condicion = 1;
        $cursada->aprobada = 1;
      }else if($condicion=='p'){
        $cursada->condicion = 2;
        $cursada->aprobada = 1;
      }else if($condicion=='e'){
        $cursada->condicion = 3;
        $cursada->aprobada = 1;
      }else if($condicion=='l'){
        $cursada->condicion = 0;
        $cursada->aprobada = 1;
      }
      $cursada->save();
    }
    return redirect()->back();

})->name('admin.cursadas.masivo.post');


Route::get('set-horarios', function(){
  foreach (Mesa::whereRaw('fecha > NOW()')->get() as $mesa) {
      $fecha = Carbon::parse($mesa->fecha);
      $mesa->fecha = $fecha->addMinutes(420+($mesa->hora*15))->format('Y-m-d H:i:s');
      $mesa->save();
  }
});



});