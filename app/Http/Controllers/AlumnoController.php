<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\CarreraDefault;
use App\Models\Cursada;
use App\Models\Examen;
use App\Models\Mesa;
use App\Services\DiasHabiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*
 | -----------------------------
 | Acciones del usuario, como:
 |  - ver su informacion
 |  - ver sus cursadas
 |  - anotarse/bajarse de mesas
 |  - etc
 | -----------------------------
 */

class AlumnoController extends Controller
{


    /*
     | --------------------------------
     | Todas las rutas estan protegidas
     | --------------------------------
     */

    public function __construct()
    {
        $this -> middleware('auth:web');
    }


    /*
     | -------------------------------------------
     | informacion genereal del alumno
     | y un select para elegir una carrera default
     |  ---------------------------------------------
     */

    function info(){
        // carreras que el alumno cursa o curso
        $carreras = Carrera::select('carrera.id', 'carrera.nombre')
        -> join('asignaturas', 'asignaturas.id_carrera', 'carrera.id')
        -> join('cursada', 'cursada.id_asignatura', 'asignaturas.id')
        -> where('cursada.id_alumno', Auth::id()) 
        -> groupBy('carrera.id', 'carrera.nombre')
        -> get();
        
        return view('Alumnos.Datos.informacion', [
            'alumno'=>Auth::user(),
            'carreras' => $carreras,
            'default' => Carrera::getDefault()
        ]);
    }


    /*
     | ----------------------------------------------------------------------------
     | Setea la carrera que el alumno haya elegido como default para los resultados
     | se guarda en la tabla: carreras_default
     | ----------------------------------------------------------------------------
     */

     function setCarreraDefault(Request $request){
        $data = [
            'id_alumno' => Auth::id(),
            'id_carrera' => $request -> carrera
        ];

        CarreraDefault::updateOrInsert($data);

        return redirect()->back();
    }


    /*
     | ---------------------------------------------
     | ver todas las cursadas del alumno y su estado
     | ---------------------------------------------
     */

    function cursadas(Request $request){

        $filtro = "*";
        $cursadas=[];

        if($request->has('filtro')){

            $filtro = $request->filtro;

                if($request->campo == "anio"){
                    $cursadas = Cursada::where('id_alumno', Auth::id())
                    -> with('asignatura') -> where('cursada.anio_cursada',$filtro)
                    -> get();
                }
                else if($request->campo == "materia"){
                    $cursadas = Cursada::where('id_alumno', Auth::id())
                    -> whereRelation('asignatura','asignaturas.nombre','LIKE','%'.$filtro.'%')
                    -> get();
                }
                else if($request->campo == "anio_carrera"){
                    $cursadas = Cursada::where('id_alumno', Auth::id())
                    -> whereRelation('asignatura','asignaturas.anio','LIKE','%'.$filtro.'%')
                    -> get();
                }
        }else{
            $cursadas = Cursada::where('id_alumno', Auth::id())->with('asignatura')->get();
        }

        // lista de examenes aprobados para saber si una cursada
        // tiene rendido su final
        $examenesAprobados = DB::table('examenes')
            -> select('mesa.id_asignatura')
            -> join('mesa','examenes.id_mesa','mesa.id')
            -> where('examenes.nota','>=',4)
            -> where('examenes.id_alumno',Auth::id())
            -> get()
            -> pluck('id_asignatura')
            -> toArray();
        
        return view('Alumnos.Datos.cursadas', [
            'cursadas' => $cursadas, 
            'examenesAprobados' => $examenesAprobados,
            'filtros' => $request->only('campo','filtro')
        ]);
    }


    /*
     | ---------------------------------------------
     | Examanes rendidos por el alumno
     | ---------------------------------------------
     */

    function examenes(){
        $examenes = Examen::selectRaw('asignaturas.nombre, MAX(examenes.nota) as nota')
        -> from('asignaturas')
        -> join('examenes','examenes.id_asignatura','=','asignaturas.id')
        -> where('examenes.id_alumno', Auth::id())
        -> where('asignaturas.id_carrera', Carrera::getDefault())
        -> groupBy('asignaturas.nombre')
        -> get();

        return view('Alumnos.Datos.examenes', compact('examenes'));
    }


    /*
     | ---------------------------------------------
     | Vista para inscribirse o bajarse a una mesa
     | ---------------------------------------------
     */

    function inscripciones(Request $request){
        $posibles = [];


        $posibles = Alumno::inscribibles();
        $request->session()->put('data', $posibles);
       // dd($posibles);
        
        


        $yaAnotadas = Examen::select('id_mesa')
            -> where('id_alumno', Auth::id())
            -> get() 
            -> pluck('id_mesa')
            -> toArray();

        return view('Alumnos.Datos.inscripciones',[
            'materias' => $posibles,
            'yaAnotadas' => $yaAnotadas,
        ]);

    }


    /*
     | ---------------------------------------------
     | Solicitud de inscripcion a mesa [post] 
     | ---------------------------------------------
     */

    function inscribirse(Request $request){
        $mesa = $request->mesa;

        $posibles = [];

        if($request->session()->has('data')) $posibles = $request->session()->get('data');
        else $posibles = Alumno::inscribibles();

        $noPuede = true;
        $finBusqueda = false;
        
        // la materia que selecciono esta en las que puede inscribirse
        // y no caduco la fecha de inscripcion
        foreach($posibles as $materia){

            if($finBusqueda) break;

            foreach($materia->mesas as $mesaMateria){
                
                if($mesaMateria->id == $mesa){               
                    if(DiasHabiles::desdeHoyHasta($mesaMateria->fecha) >= 2) $noPuede = false;
                    else break;
                    $finBusqueda=true;
                }
            }
        }

        if($noPuede) return redirect()->route('alumno.inscripciones')->with('error', 'No puedes anotarte a esta mesa');

        $yaAnotado = Examen::select('id')
            -> where('id_mesa', $mesa)
            -> where('id_alumno', Auth::id())
            -> first();

        if($yaAnotado) return redirect()->route('alumno.inscripciones')->with('error', 'Ya estas en esta esta mesa');

        Examen::create([
            'id_mesa' => $mesa,
            'id_alumno'  => Auth::id(),
            'nota'=>'0.00',
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
        if(!$request->has('mesa')) return redirect()->route('alumno.inscripciones');
        
        $mesa = Mesa::select('fecha','id')
            -> where('id', $request->mesa)
            -> first();
        
        $examen = Examen::select('id')
            -> where('id_mesa', $mesa->id)
            -> where('id_alumno', Auth::id())
            -> first();

        if(!$examen){
            return redirect()->route('alumno.inscripciones')->with('error','No estas inscripto en esta mesa.');
        }
        
        if(DiasHabiles::desdeHoyHasta($mesa->fecha) <= 1){
            return redirect()->route('alumno.inscripciones')->with('error', 'Timpo de desincripcion caducado.');
        }

        $examen->delete();
        $request->session()->forget('data');

        return redirect()->route('alumno.inscripciones')->with('mensaje','Te has dado de baja de la mesa.');

    }
}
