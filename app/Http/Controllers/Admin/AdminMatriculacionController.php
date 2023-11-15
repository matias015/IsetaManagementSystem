<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Carrera;
use App\Models\Configuracion;
use App\Models\Correlativa;
use App\Models\Cursada;
use App\Models\Egresado;
use App\Services\AlumnoMatriculacionService;
use Illuminate\Http\Request;

class AdminMatriculacionController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }

    /*
     | ---------------------------------------------
     | Vista de rematriculacion
     | ---------------------------------------------
     */
    function rematriculacion_vista(Request $request,Alumno $alumno, AlumnoMatriculacionService $matriculacionService){
        $carrera = Carrera::where('id', $request->input('carrera'))->first();

        $anotables =$matriculacionService->matriculables($alumno,$carrera);

        return view('Admin.Alumnos.rematriculacion', [
            'asignaturas' => $anotables, 
            'carrera'=>$carrera,
            'alumno' => $alumno
        ]);
    }


    /*
     | ---------------------------------------------
     | Post de rematriculacion
     | ---------------------------------------------
     */
    

     // Falta chequear lo mismo que arriba

    public function rematriculacion(Request $request, Alumno $alumno,Carrera $carrera, AlumnoMatriculacionService $rematService){
       
        /// Ver que no haya seleccionado mas de 2 libres
        $libres=0;
        foreach ($request->except('_token') as $value) {
            if($value == 1){
                $libres++;
            }
        }
        
        $asignaturas = $rematService->validasParaRegistrar($carrera,$request->except('_token'),$alumno);

        if(!$asignaturas['success']) return redirect()->back()->with('error',$asignaturas['mensaje']);
        else $asignaturas = $asignaturas['mensaje'];

        // Año de la rematriculacion
        $anio_remat = Configuracion::get('anio_remat');
    
        // Registrar las cursadas
        foreach($asignaturas as $asigId => $tipoCursada){
            Cursada::create([
                'id_asignatura' => $asigId,
                'id_alumno' => $alumno->id,
                'condicion' => $tipoCursada-1,
                'aprobada' => $tipoCursada==1? 1:3,
                'anio_cursada' => $anio_remat
            ]);
        }

        return redirect()->back()->with('mensaje','Te has rematriculado correctamente'); 

        // Año de la rematriculacion
        $config = Configuracion::todas();
        $anio_remat = $config['anio_remat'];


        if(!Egresado::where('id_alumno',$alumno->id)->where('id_carrera',$carrera->id)->exists()){  
            Egresado::create([
                'id_alumno' => $alumno->id,
                'id_carrera' => $carrera->id,
                'anio_inscripcion' => $anio_remat
            ]);
        }


        
        return redirect()->back()->with('mensaje','Se ha rematriculado correctamente');       
    }

}
