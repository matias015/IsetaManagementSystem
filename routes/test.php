<?php

use App\Http\Controllers\Admin\AdminCursadasLotes;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Carrera;
use App\Models\Correlativa;
use App\Models\Cursada;
use App\Models\Egresado;
use App\Models\Examen;
use App\Models\Mesa;
use App\Models\Profesor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mockery\CountValidator\Exact;

Route::middleware(['web','auth:admin'])->prefix('admin')->group(function(){

Route::get('test',function(){
  $carrera = Carrera::with('asignaturas')->where('nombre','test_carrera')->first();
  foreach($carrera->asignaturas as $asignatura){
    foreach(Mesa::where('id_asignatura',$asignatura->id)->get() as $mesa){
      if($mesa->asignatura->nombre == 'Test_asignatura_mismo_anio_3'){
        if($mesa->llamado==1)$mesa->fecha = Carbon::now()->addHours(15);
        else if($mesa->llamado==2)$mesa->fecha = Carbon::now()->addDays(10);
      }
      else if($mesa->llamado==1)$mesa->fecha = Carbon::now()->addHours(24);
      else if($mesa->llamado==2)$mesa->fecha = Carbon::now()->addDays(10);
      $mesa->save();
    }
  }

  Auth::logout();
  Auth::guard('web')->login(Alumno::where('email','test@gmail.com')->first());
  return redirect('/')->with('mensaje','Estas con el usuario de prueba'); 
});

Route::get('crear-test-user',function(){

    // Crear alumno
    if(!Alumno::where('email','test@gmail.com')->exists()){
      Alumno::create([
        'dni' => 55555555,
        'nombre' => 'test_nombre',
        'apellido' => 'test_apellido',
        'fecha_nacimiento' => now(),
        'ciudad' => 'test_ciudad',
        'calle' => 'test_calle',
        'casa_numero' => 555,
        'dpto' => 2,
        'piso' => 2,
        'estado_civil' => 1,
        'email' => 'test@gmail.com',
        'titulo_anterior' => 'test_titulo_anterior',
        'becas' => 2,
        'observaciones' => 'test_observaciones',
        'telefono1' => '2317555555',
        'telefono2' => '2317666666',
        'telefono3' => '2317777777',
        'codigo_postal' => '6500'
      ]);
    }



    // Crear Carrera
    if(!Carrera::where('nombre','test_carrera')->exists()){
      Carrera::create([
        "nombre" => 'test_carrera',
        "resolucion" => 'test_resolucion',
        "anio_apertura" => '2000',
        "anio_fin" => '0',
        'vigente' => 1,
        "observaciones" => 'test_observaciones'
      ]);
    }

    $alumno = Alumno::where('email','test@gmail.com')->first();
    $alumno->password = bcrypt('123');
    $alumno->verificado = 1;
    $alumno->save();

    $carrera = Carrera::where('nombre','test_carrera')->first();

    foreach(Asignatura::where('id_carrera',$carrera->id)->get() as $asig){
      $corr = Correlativa::where('id_asignatura',$asig->id)->orWhere('asignatura_correlativa',$asig->id)->first();
      if($corr) $corr->delete();
      $asig->delete();
    }

    // Inscribir al alumno
    if(!Egresado::where('id_carrera',$carrera->id)->exists()){
      Egresado::create([
        'id_alumno' => $alumno->id,
        'id_carrera'=> $carrera->id,
        'anio_inscripcion' => 2020
      ]);
    }


    $asignaturas=[];

    // Crear asignaturas
    for($i=1; $i<=7; $i++){
      if(!Asignatura::where('nombre','test_asignatura_'.$i)->exists()){
        $asig = Asignatura::create([
          'nombre' => 'test_asignatura_'.$i,
          'id_carrera' => $carrera->id,
          'tipo_modulo' => 1,
          'carga_horaria' => 25,
          'anio' => $i,
          'observaciones' => 'test_observaciones'
        ]);

        $asignaturas[]=$asig;

        if($i == 3){
          $asig = Asignatura::create([
            'nombre' => 'test_asignatura_mismo_anio_'.$i,
            'id_carrera' => $carrera->id,
            'tipo_modulo' => 1,
            'carga_horaria' => 25,
            'anio' => $i,
            'observaciones' => 'test_observaciones'
          ]);

          $asignaturas[]=$asig;
        }

      }
    }
    
    $combinaciones = [
      [2,1], // Promocion
      [0,1], // Libre
      [0,1], // Libre
      [3,1], // Equivalencia
      [1,1], // Regular Aprobado
      [3,1], // Equivalencia
      [1,3], // Regular Cursando
      [1,2], // Regular DesAprobado
    ];

    foreach($asignaturas as $key => $asignatura){  
      
      $comb = $combinaciones[$key];
      
      Cursada::create([
        'id_asignatura' => $asignatura->id,
        'id_alumno' => $alumno->id,
        'anio' => 2020,
        'condicion' => $comb[0],
        'aprobada' => $comb[1]
      ]);
    }


    foreach(Examen::where('id_alumno', $alumno->id,)->get() as $ex){
      $ex->delete();
    }

    Examen::create([
      'id_alumno' => $alumno->id,
      'id_asignatura' => $asignaturas[0]->id,
      'fecha' => now(),
      'nota' => 8
    ]);
    
    Examen::create([
      'id_alumno' => $alumno->id,
      'id_asignatura' => $asignaturas[1]->id,
      'fecha' => now(),
      'nota' => 6
    ]);

    foreach(Mesa::where('id_carrera', $carrera->id,)->get() as $mesa){
      $mesa->delete();
    }

    foreach($asignaturas as $asignatura){   
      
      
      
      $mesa = Mesa::create([
        'id_asignatura' => $asignatura->id,
        'id_carrera' => $carrera->id,
        'prof_presidente' => Profesor::first()->id,
        'prof_vocal_1' => 0,
        'prof_vocal_2' => 0,
        'llamado' => 1,
        'fecha' => Carbon::now()->addHours(24),
      ]);

      if($asignatura->nombre == 'Test_asignatura_mismo_anio_3'){
        Examen::create([
          'id_alumno' => $alumno->id,
          'id_asignatura' => $asignatura->id,
          'id_mesa' => $mesa->id,
          'fecha' => now(),
          'nota' => 0
        ]);
      }

      Mesa::create([
        'id_asignatura' => $asignatura->id,
        'id_carrera' => $carrera->id,
        'prof_presidente' => Profesor::first()->id,
        'prof_vocal_1' => 0,
        'prof_vocal_2' => 0,
        'llamado' => 2,
        'fecha' => Carbon::now()->addDays(10),
      ]);
    }

    $ids=[];
    foreach($asignaturas as $asig){
      $ids[]=$asig->id;
    }

    
    

    Correlativa::create([
      'id_asignatura' => $ids[1],
      'asignatura_correlativa' => $ids[0]
    ]);   
    Correlativa::create([
      'id_asignatura' => $ids[2],
      'asignatura_correlativa' => $ids[1]
    ]);
    Correlativa::create([
      'id_asignatura' => $ids[3],
      'asignatura_correlativa' => $ids[1]
    ]);
    Correlativa::create([
      'id_asignatura' => $ids[4],
      'asignatura_correlativa' => $ids[3]
    ]);
    Correlativa::create([
      'id_asignatura' => $ids[5],
      'asignatura_correlativa' => $ids[4]
    ]);
    Correlativa::create([
      'id_asignatura' => $ids[6],
      'asignatura_correlativa' => $ids[5]
    ]);

    Correlativa::create([
      'id_asignatura' => $ids[7],
      'asignatura_correlativa' => $ids[6]
    ]);
});
  





Route::get('set-horarios', function(){
  foreach (Mesa::whereRaw('fecha > NOW()')->get() as $mesa) {
      $fecha = Carbon::parse($mesa->fecha);
      $mesa->fecha = $fecha->addMinutes(420+($mesa->hora*15))->format('Y-m-d H:i:s');
      $mesa->save();
  }
});



});

