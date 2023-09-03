<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Carrera;
use App\Models\CarreraDefault;
use App\Models\Configuracion;
use App\Models\Cursada;
use App\Models\Examen;
use App\Models\Mesa;
use App\Services\DiasHabiles;
use App\Services\TextFormatService;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\returnValue;

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
        $carreras = Carrera::select('carreras.id', 'carreras.nombre')
        -> join('asignaturas', 'asignaturas.id_carrera', 'carreras.id')
        -> join('cursadas', 'cursadas.id_asignatura', 'asignaturas.id')
        -> where('cursadas.id_alumno', Auth::id()) 
        -> groupBy('carreras.id', 'carreras.nombre')
        -> get();

        foreach($carreras as $carrera){
            $carrera->nombre = TextFormatService::utf8Minusculas($carrera->nombre);
        }
        
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

        $existente = CarreraDefault::where('id_alumno', Auth::id())->first();

        if($existente){
            $existente->id_carrera = $data['id_carrera'];
            $existente->save();
        }else{
            CarreraDefault::create($data);
        }

        return redirect()->back();
    }


    /*
     | ---------------------------------------------
     | ver todas las cursadas del alumno y su estado
     | ---------------------------------------------
     */

    function cursadas(Request $request){

        $cursadas=[];
        
        $filtro = $request->filtro ? $request->filtro: '';
        $campo = $request->campo ? $request->campo: '';
        $orden = $request->orden ? $request->orden: 'fecha';
        
        $porPagina = 15;

        // cursadas del alumno de la carrera seleccionada
        $query = Cursada::where('id_alumno', Auth::id())
            -> where('asignaturas.id_carrera', Carrera::getDefault(Auth::id())) 
            -> join('asignaturas','asignaturas.id','cursadas.id_asignatura');

        if($request->has('filtro')){
            $query =  $query -> where('asignaturas.nombre','LIKE','%'.$filtro.'%');
        }

        if($campo == "aprobadas"){
            $query =  $query -> where('cursadas.aprobada', 1);
        }
        else if($campo == "desaprobadas"){
            $query =  $query -> where('cursadas.aprobada', 2);
        }


        if($orden == 'anio'){
            $query->orderBy('asignaturas.anio');
        }            
        else if($orden == 'anio_cursada'){
            $query->orderBy('cursadas.anio_cursada');
        }
        else if($orden == 'anio_desc'){
            $query->orderBy('asignaturas.anio','desc');
        }            
        else if($orden == 'anio_cursada_desc'){
            $query->orderBy('cursadas.anio_cursada','desc');
        }

        $cursadas = $query->get();
        // lista de examenes aprobados para saber si una cursada
        // tiene rendido su final
        $examenesAprobados = Examen::select('examenes.id_asignatura')
            -> where('examenes.nota','>=',4)
            -> where('examenes.id_alumno',Auth::id())
            -> orderBy('examenes.id_asignatura')            
            -> get()-> pluck('id_asignatura')-> toArray();

        return view('Alumnos.Datos.cursadas', [
            'cursadas' => $cursadas, 
            'examenesAprobados' => $examenesAprobados,
            'filtros'=>[
                'campo' => $campo,
                'orden' => $orden,
                'filtro' => $filtro
            ]
        ]);
    }


    /*
     | ---------------------------------------------
     | Examanes rendidos por el alumno
     | ---------------------------------------------
     */

    function examenes(){

        $examenes = Examen::delAlumnoMasAltas();

        $promedio = 0;
        foreach($examenes as $examen){
            $promedio += $examen->nota;
        }
        
        $cantidadDeExamenes = count($examenes);

        if($cantidadDeExamenes < 1) $promedio = 0;
        else $promedio = $promedio / $cantidadDeExamenes;
        
        return view('Alumnos.Datos.examenes', ['examenes'=>$examenes,'promedio'=>$promedio]);
    }


    /*
     | ---------------------------------------------
     | Vista para inscribirse o bajarse a una mesa
     | ---------------------------------------------
     */

    function inscripciones(Request $request){
        $posibles = [];
        $config = Configuracion::todas();   

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

        $config = Configuracion::todas();   

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
                    if(DiasHabiles::desdeHoyHasta($mesaMateria->fecha) <= $config['horas_habiles_inscripcion']){
                        return redirect()->route('alumno.inscripciones')->with('error', 'Ha caducado el tiempo de inscripcion');
                    }
                    $noPuede = false;
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

        
        $mesa = Mesa::find($mesa);  

        Examen::create([
            'id_mesa' => $mesa->id,
            'id_alumno'  => Auth::id(),
            'nota'=>'0.00',
            'id_asignatura' => $mesa->id_asignatura
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
        
        if(DiasHabiles::desdeHoyHasta($mesa->fecha) <= $config['horas_habiles_desinscripcion']){
            return redirect()->route('alumno.inscripciones')->with('error', 'Timpo de desincripcion caducado.');
        }

        $examen->delete();
        $request->session()->forget('data');

        return redirect()->route('alumno.inscripciones')->with('mensaje','Te has dado de baja de la mesa.');

    }

    function remat_carrera_vista(){
        $carreras = Carrera::all();
        $config = Configuracion::todas();
        $inicial = new DateTime($config['fecha_inicial_rematriculacion']);
        $final = new DateTime($config['fecha_final_rematriculacion']);
        
        $en_fecha = false;
        if(time()>$inicial->getTimestamp() && time()<$final->getTimestamp()){
            $en_fecha=true;
        }
        
        return view('Alumnos.datos.remat-seleccionar-carrera', ['carreras'=>$carreras,'en_fecha'=>$en_fecha]);
    }

    /*
     | ---------------------------------------------
     | Vista de rematriculacion
     | ---------------------------------------------
     */
    function rematriculacion_vista(Request $request,Carrera $carrera){

        // todas las materias de esa carrera
        
        $asignaturas = $carrera->asignaturas;
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
            if(count($asignatura->correlativas)>0){
                $previas = [];

                // Ver si estan aprobadas
                foreach($asignatura->correlativas as $correlativa){
                    $aprobado = Asignatura::where('asignaturas.id',$correlativa->asignatura_correlativa)
                        -> join('cursadas', 'cursadas.id_asignatura','asignaturas.id')
                        -> join('examenes', 'examenes.id_asignatura','asignaturas.id')
                        -> where('cursadas.id_alumno', Auth::id()) -> where('cursadas.aprobada', 1)
                        -> first();

                    if(!$aprobado){
                        $asignatura->equivalencias_sin_aprobar = true;
                        $previas[] = 'año '.$correlativa->asignatura->anio+1 .' - '.$correlativa->asignatura->nombre;     
                    }
                }
                
                // Cargamos la info de que materias debe
                $asignatura->equivalencias_previas = $previas;
                
            }

            // Cargamos a inscribibles
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

       
        //todas la materias de esa carrera
        $asignaturas_de_carrera = $carrera->asignaturas()->pluck('id')->toArray();

        $totalLibres = array_count_values($request->except('_token'))[2];
        if($totalLibres > 2) return redirect()->back()->with('error','No puedes cursar mas de 2 materias libres');

        //asignaturas que se seleccionaron que sean validas para inscripcion
        $asignaturas = [];
        
        foreach($request->except('_token') as $asig_id => $value){
            // si no se selecciono ignora, si no es de la carrera: error 
            if($value==0) continue;
            if(!in_array($asig_id, $asignaturas_de_carrera)) return \redirect()->back()->with('error','error 1');
            
            $asignatura = Asignatura::with('correlativas.asignatura')->where('id', $asig_id)->first();
            
            // verifica equivalencias
            foreach($asignatura->correlativas as $correlativa){
                $aprobado = Asignatura::where('asignaturas.id',$correlativa->asignatura_correlativa)
                    -> join('cursadas', 'cursadas.id_asignatura','asignaturas.id')
                    -> join('examenes', 'examenes.id_asignatura','asignaturas.id')
                    -> where('cursadas.id_alumno', Auth::id()) -> where('cursadas.aprobada', 1)
                    -> first();

                if(!$aprobado) return redirect()->back()->with('error', 'Debes 1 o mas equivalencias');
            }
            $asignaturas[$asig_id] = $value;
        }

        $anio_remat = Configuracion::get('anio_remat');
    
        foreach($asignaturas as $asigId => $tipoCursada){
            Cursada::create([
                'id_asignatura' => $asigId,
                'id_alumno' => Auth::id(),
                'condicion' => $tipoCursada,
                'aprobada' => 3,
                'anio_cursada' => $anio_remat
            ]);
        }   
    
    }

    

}
