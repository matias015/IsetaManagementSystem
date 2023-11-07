<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Configuracion;
use App\Models\Correlativa;
use App\Models\Examen;
use App\Models\Mesa;
use App\Services\DiasHabiles;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class InscripcionController extends Controller
{

    public function __construct()
    {
        $this -> middleware('auth:web');
        $this -> middleware('verificado')->only([
            'inscribirse',
            'bajarse',
        ]);
    }

     /*
     | ---------------------------------------------
     | Vista para inscribirse o bajarse a una mesa
     | ---------------------------------------------
     */

     function inscripciones(Request $request){
        return view('Alumnos.Datos.inscripciones',['disponibles'=>Alumno::inscribibles2()]);
    }


    /*
     | ---------------------------------------------
     | Solicitud de inscripcion a mesa [post] 
     | ---------------------------------------------
     */

    function inscribirse(Request $request){
        $config = Configuracion::todas();   

        $mesa = $request->mesa;
        if(!$mesa) return redirect()->back()->with('error','Selecciona una mesa');

        $mesaDb = Mesa::with('asignatura','anotado')->find($mesa);
        
        if(!$mesaDb) return redirect()->route('alumno.inscripciones')->with('error','No se encontro la mesa');

        if($mesaDb->anotado) return \redirect()->back()->with('error','Ya estas anotado en esta asignatura');

        if(!$mesaDb->habilitada()) return redirect()->back()->with('error', 'Ha caducado el tiempo de inscripcion');
        

        if($mesaDb->asignatura->aproboExamen(Auth::user())){
            return redirect()->back()->with('error', 'Ya aprobaste esta asignatura');
        }

        if(!$mesaDb->asignatura->aproboCursada(Auth::user())) {
            return redirect()->back()->with('error', 'Aun no aprobaste la cursada de esta asignatura');
        }

        
        $correlativas = Correlativa::debeExamenesCorrelativos($mesaDb->asignatura);

        if($correlativas){
            $mensaje = "Debes: ";

            foreach ($correlativas as $correlativa) {
                $mensaje = "$mensaje > $correlativa->nombre";
            }            
            return redirect()->back()->with('error', "Debes: $mensaje");
        }

        if($mesaDb->llamado == 2){
            $yaAnotadoAllamado1 = Examen::join('mesas','mesas.id','examenes.id_mesa')
                -> where('examenes.id_asignatura', $mesaDb->id_asignatura)
                -> where('mesas.llamado', 1)
                -> where('examenes.id_alumno', Auth::id())
                -> first();
                
            if($yaAnotadoAllamado1){
                $diferencia = DiasHabiles::desdeHoyHasta($yaAnotadoAllamado1->fecha, $mesaDb->fecha)*-1;
                $diferencia = $diferencia/24;

                if($diferencia>0 && $diferencia<$config['diferencia_llamados']){
                    return redirect()->back()->with('error','Ya has rendido el llamado 1');
                }
            }
            

        }
        

        
        $mesa = Mesa::find($mesa);  

        Examen::create([
            'id_mesa' => $mesa->id,
            'id_alumno'  => Auth::id(),
            'nota'=>'0.00',
            'id_asignatura' => $mesa->id_asignatura,
            'fecha' => $mesa->fecha
        ]);

        $request->session()->forget('data');
        return redirect()->route('alumno.inscripciones')->with('mensaje', 'Te has anotado a la mesa');
    }


    /*
     | ---------------------------------------------
     | Solicitud para bajarse de una mesa [post] 
     | ---------------------------------------------
     */

    function bajarse(Request $request){

        $config = Configuracion::todas();   

        if(!$request->has('mesa')){ 
            return redirect()->route('alumno.inscripciones')->with('error','Selecciona una mesa');
        }
        
        $mesa = Mesa::select('fecha','id')
            -> where('id', $request->mesa)
            -> first();
        
        if(!$mesa) return redirect()->route('alumno.inscripciones')->with('error','No se encontro la mesa');

        $examen = Examen::select('id')
            -> where('id_mesa', $mesa->id)
            -> where('id_alumno', Auth::id())
            -> first();

        if(!$examen){
            return redirect()->route('alumno.inscripciones')->with('error','No estas inscripto en esta mesa.');
        }
        
        if(DiasHabiles::desdeHoyHasta($mesa->fecha) <= $config['horas_habiles_desinscripcion']){
            return redirect()->route('alumno.inscripciones')->with('error', 'Timpo de desincripcion caducado.');
        }

        $examen->delete();
        $request->session()->forget('data');

        return redirect()->back()->with('mensaje','Te has dado de baja de la mesa.');
    }

}
