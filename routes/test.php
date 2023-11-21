<?php

use App\Http\Controllers\Admin\AdminCursadasLotes;
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










Route::get('set-horarios', function(){
  foreach (Mesa::whereRaw('fecha > NOW()')->get() as $mesa) {
      $fecha = Carbon::parse($mesa->fecha);
      $mesa->fecha = $fecha->addMinutes(420+($mesa->hora*15))->format('Y-m-d H:i:s');
      $mesa->save();
  }
});



});