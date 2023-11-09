<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use App\Models\Carrera;
use App\Models\Configuracion;
use App\Models\Correlativa;
use App\Models\Cursada;
use App\Services\DiasHabiles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class RematriculacionController extends Controller
{

    public function __construct()
    {
        $this -> middleware('auth:web');
        $this -> middleware('verificado')->only([
            'rematriculacion',
            'bajar_rematriculacion'
        ]);
    }

     /*
     | ---------------------------------------------
     | Vista de rematriculacion
     | ---------------------------------------------
     */
    function rematriculacion_vista(Request $request){


        $carrera = Carrera::getDefault();
        
        // todas las materias de esa carrera
        $asignaturas = Asignatura::where('id_carrera',$carrera->id)->get();
        
        $anotables = [];

        // para cada asignatura 
        foreach($asignaturas as $key => $asignatura){

            // array para almancenar correlativas, solo en caso de que deba equivalencias
            $asignatura->{'equivalencias_previas'} = array();

            // Chequear que no este ya en la cursada
            $yaAnotadoEnCursada = Cursada::where('id_alumno', Auth::id())
                -> whereRaw('(aprobada=3 OR aprobada=1)')
                -> where('id_asignatura', $asignatura->id)
                -> first();

            // Si lo esta, no incluir
            if($yaAnotadoEnCursada) continue;
            
            // Si la materia tiene correlativas
            $asignatura->equivalencias_previas = Correlativa::debeCursadasCorrelativos($asignatura);

            $anotables[] = $asignatura;
        }
        
        return view('Alumnos.datos.rematriculacion', ['asignaturas' => $anotables, 'carrera'=>$carrera->id]);
    }


    /*
     | ---------------------------------------------
     | Post de rematriculacion
     | ---------------------------------------------
     */
    

     // Falta chequear lo mismo que arriba

    public function rematriculacion(Request $request, Carrera $carrera){

       
        if(!$carrera->estaInscripto()){
            return redirect()->back()->with('error','No estas inscripto en esta carrera');
        }

        //todas la materias de esa carrera
        $asignaturas_de_carrera = $carrera->asignaturas()->pluck('id')->toArray();

        // Ver que no haya seleccionado mas de 2 libres
        $libres=0;
        foreach ($request->except('_token') as $value) {
            if($value == 1){
                $libres++;
            }
        }

        if($libres > 2) return redirect()->back()->with('error','Como fines de testeos, no puedes cursar mas de 2 materias libres');

        //asignaturas que se seleccionaron que sean validas para inscripcion
        $asignaturas = [];
        
        // para cada materia
        foreach($request->except('_token') as $asig_id => $value){

            // si no se selecciono ignora, si no es de la carrera
            if($value==0) continue;
            
            // Si la asignatura no es de esta carrera, error
            if(!in_array($asig_id, $asignaturas_de_carrera)) return \redirect()->back()->with('error','Ha habido un error');
            
            // Si se selecciono otra cosa ademas de las posibles
            if($value!=1 && $value!=2){
                return \redirect()->back()->with('error','Ha habido un error');
            }

            // Ver que no este ya anotado o que ya la haya aprobado
            $yaAnotadoEnCursada = Cursada::where('id_alumno', Auth::id())
                -> whereRaw('(aprobada=3 OR aprobada=1)')
                -> where('id_asignatura', $asig_id)
                -> first();

            // Si lo esta, no incluir
            if($yaAnotadoEnCursada) {
                return redirect()->back()->with('error','Ya has cursado 1 o mas materias');
            }

            // Obtener datos de la asignatura con sus correlativas
            $asignatura = Asignatura::with('correlativas.asignatura')->where('id', $asig_id)->first();
            
            // verifica equivalencias
            if(Correlativa::debeCursadasCorrelativos($asignatura)){
                return redirect()->back()->with('error', 'Debes 1 o mas correlativas');
            }

            $asignaturas[$asig_id] = $value;
        }


        // Año de la rematriculacion
        $anio_remat = Configuracion::get('anio_remat');
    
        // Registrar las cursadas
        foreach($asignaturas as $asigId => $tipoCursada){
            Cursada::create([
                'id_asignatura' => $asigId,
                'id_alumno' => Auth::id(),
                'condicion' => $tipoCursada-1,
                'aprobada' => $tipoCursada==1? 1:3,
                'anio_cursada' => $anio_remat
            ]);
        }
        return redirect()->back()->with('mensaje','Te has rematriculado correctamente');       
    }




    function bajar_rematriculacion(Request $request, Cursada $cursada){
        
        if(!$cursada) return redirect()->route('alumno.inscripciones')->with('error','No se encontro la mesa');


        if(!Gate::allows('delete-cursada', $cursada)){
            return \redirect()->back()->with('error', 'Esta cursada no te pertenece... &#129320;');
        }
        
        if($cursada->aprobada != 3 && $cursada->condicion!=0) return redirect()->back()->with('error','Ya has terminado de cursar');
        
        $config = Configuracion::todas();

        if(DiasHabiles::desdeHoyHasta($config['fecha_limite_desrematriculacion'])<=0){
            return redirect()->back()->with('error','Ya ha caducado el tiempo para desmatricularse');
        }

        if($cursada->anio_cursada != $config['anio_remat']){
            return redirect()->back()->with('error','Ya estas cursando esta asignatura');
        }

        $cursada->delete();
        return redirect()->back()->with('mensaje','Se ha eliminado la cursada');
    }
}
