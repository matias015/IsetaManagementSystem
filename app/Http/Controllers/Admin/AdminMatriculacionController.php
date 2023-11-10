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
    function rematriculacion_vista(Request $request,Alumno $alumno){
        $carrera = Carrera::where('id', $request->input('carrera'))->first();
        // todas las materias de esa carrera
        $asignaturas = $carrera->asignaturas;
        $anotables = [];

        // para cada asignatura 
        foreach($asignaturas as $key => $asignatura){

            // array para almancenar correlativas, solo en caso de que deba equivalencias
            $asignatura->{'equivalencias_previas'} = array();

            // Chequear que no este ya en la cursada
            $yaAnotadoEnCursada = Cursada::where('id_alumno', $alumno->id)
                -> whereRaw('(aprobada=3 OR aprobada=1 OR condicion=2 OR condicion=3)')
                -> where('id_asignatura', $asignatura->id)
                -> first();

            // Si lo esta, no incluir
            if($yaAnotadoEnCursada) continue;
            
            // Si la materia tiene correlativas
            $asignatura->equivalencias_previas = Correlativa::debeCursadasCorrelativos($asignatura,$alumno);

            // Cargamos a inscribibles
            $anotables[] = $asignatura;
        }

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

    public function rematriculacion(Request $request, Alumno $alumno,Carrera $carrera){
       
        //todas la materias de esa carrera
        $asignaturas_de_carrera = $carrera->asignaturas()->pluck('id')->toArray();

        // Ver que no haya seleccionado mas de 2 libres
        $libres=0;
        // dd($request->except('token'));
        foreach ($request->except('_token') as $value) {
            if($value===0){
                $libres++;
            }
        }

        if($libres > 2) return redirect()->back()->with('error','Como fines de testeos, no puedes cursar mas de 2 materias libres');

        //asignaturas que se seleccionaron que sean validas para inscripcion
        $asignaturas = [];
        
        // para cada materia
        foreach($request->except('_token') as $asig_id => $value){

            // si no se selecciono ignora, si no es de la carrera
            if(!$value) continue;
            
            // Si la asignatura no es de esta carrera, error
            if(!in_array($asig_id, $asignaturas_de_carrera)) return \redirect()->back()->with('error','Ha habido un error');
            
            // Si se selecciono otra cosa ademas de las posibles
            if($value!=0 && $value!=1){
                return \redirect()->back()->with('error','Ha habido un error');
            }

            // Ver que no este ya anotado o que ya la haya aprobado
            $yaAnotadoEnCursada = Cursada::where('id_alumno', $alumno->id)
                -> whereRaw('(aprobada=3 OR aprobada=1 OR condicion=2 OR condicion=3)')
                -> where('id_asignatura', $asig_id)
                -> first();

            // Si lo esta, no incluir
            if($yaAnotadoEnCursada) {
                return redirect()->back()->with('error','Ya has cursado 1 o mas materias');
            }

            // Obtener datos de la asignatura con sus correlativas
            $asignatura = Asignatura::with('correlativas.asignatura')->where('id', $asig_id)->first();
            
            // verifica equivalencias
            if(Correlativa::debeCursadasCorrelativos($asignatura,$alumno)) {
                return redirect()->back()->with('error', 'Debes 1 o mas correlativas');
            }
 
            $asignaturas[$asig_id] = $value;
        }

        // Año de la rematriculacion
        $config = Configuracion::todas();
        $anio_remat = $config['anio_remat'];


            Egresado::create([
                'id_alumno' => $alumno->id,
                'id_carrera' => $carrera->id,
                'anio_inscripcion' => $anio_remat
            ]);


        // Registrar las cursadas
        foreach($asignaturas as $asigId => $tipoCursada){
            Cursada::create([
                'id_asignatura' => $asigId,
                'id_alumno' => $alumno->id,
                'condicion' => $tipoCursada,
                'aprobada' => 3,
                'anio_cursada' => $anio_remat
            ]);
        }
        
        return redirect()->back()->with('mensaje','Te has rematriculado correctamente');       
    }

}
