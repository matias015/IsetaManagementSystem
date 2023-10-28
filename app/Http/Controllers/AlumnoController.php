<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Carrera;
use App\Models\CarreraDefault;
use App\Models\Configuracion;
use App\Models\Correlativa;
use App\Models\Cursada;
use App\Models\Egresado;
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
        $this -> middleware('verificado')->only([
            'info',
            'setCarreraDefault',
            'inscribirse',
            'bajarse',
            'rematriculacion',
            'bajar_rematriculacion'
        ]);
    }


    /*
     | -------------------------------------------
     | informacion genereal del alumno
     | y un select para elegir una carrera default
     |  ---------------------------------------------
     */

    function info(){
        // carreras que el alumno cursa o curso
        // $carreras = Carrera::select('carreras.id', 'carreras.nombre')
        // -> join('asignaturas', 'asignaturas.id_carrera', 'carreras.id')
        // -> join('cursadas', 'cursadas.id_asignatura', 'asignaturas.id')
        // -> where('cursadas.id_alumno', Auth::id()) 
        // -> groupBy('carreras.id', 'carreras.nombre')
        // -> get();
        $carreras = Egresado::select('carreras.id', 'carreras.nombre')
        -> join('carreras','egresadoinscripto.id_carrera','carreras.id')
        -> where('egresadoinscripto.id_alumno', Auth::id())
        -> get();

        foreach($carreras as $carrera){
            $carrera->nombre = TextFormatService::ucfirst($carrera->nombre);
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
        $query = Cursada::select('cursadas.id_asignatura','cursadas.anio_cursada','cursadas.id','cursadas.aprobada','cursadas.condicion','asignaturas.nombre','asignaturas.anio')
            ->where('id_alumno', Auth::id())
            -> where('asignaturas.id_carrera', Carrera::getDefault(Auth::id())->id) 
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

        $query -> orderBy('asignaturas.anio')
        -> orderBy('asignaturas.id')
        -> orderBy('cursadas.anio_cursada','desc');

        $cursadas = $query->get();
        // lista de examenes aprobados para saber si una cursada
        // tiene rendido su final
        $examenesAprobados = Examen::select('examenes.id_asignatura')
            -> where('examenes.nota','>=',4)
            -> where('examenes.id_alumno',Auth::id())
            -> orderBy('examenes.id_asignatura')            
            -> get()-> pluck('id_asignatura')-> toArray();
        // \dd($cursadas);
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

    function examenes(Request $request){

        $filtro = $request->filtro ? $request->filtro: '';
        $campo = $request->campo ? $request->campo: '';
        $orden = $request->orden ? $request->orden: 'fecha';
        

        // $examenes = Examen::delAlumnoMasAltas($filtro,$campo,$orden);
        
        $examenes = Examen::select('examenes.id_mesa','examenes.aprobado','asignaturas.id','asignaturas.anio','asignaturas.nombre','nota','id_asignatura','fecha')
        -> join('asignaturas', 'asignaturas.id','examenes.id_asignatura')
        -> where('asignaturas.id_carrera', Carrera::getDefault()->id)
        -> where('examenes.id_alumno', Auth::id())
        -> orderBy('asignaturas.anio')
        -> orderBy('asignaturas.id')
        -> orderBy('examenes.fecha')
        -> orderBy('examenes.nota','desc')
        -> get();

        $promedio = 0;
        foreach($examenes as $examen){
            $promedio += $examen->nota;
        }
        
        $cantidadDeExamenes = count($examenes);

        if($cantidadDeExamenes < 1) $promedio = 0;
        else $promedio = round($promedio / $cantidadDeExamenes,2);
        // \dd($examenes);
        return view('Alumnos.Datos.examenes', [
            'examenes'=>$examenes,
            'promedio'=>$promedio,
            'filtros'=>[
                'campo' => $campo,
                'orden' => $orden,
                'filtro' => $filtro
            ]
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

        return redirect()->back()->with('mensaje','Te has dado de baja de la mesa.');
    }

    // function remat_carrera_vista(){
    //     $carreras = Carrera::where('anio_fin',0)->orWhere('vigente',1)->get();
    //     $config = Configuracion::todas();
    //     $inicial = new DateTime($config['fecha_inicial_rematriculacion']);
    //     $final = new DateTime($config['fecha_final_rematriculacion']);
        
    //     $en_fecha = false;
    //     if(time()>$inicial->getTimestamp() && time()<$final->getTimestamp()){
    //         $en_fecha=true;
    //     }
        
    //     return view('Alumnos.datos.remat-seleccionar-carrera', ['carreras'=>$carreras,'en_fecha'=>$en_fecha]);
    // }

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
                        $previas[] = 'Año '.$correlativa->asignatura->anio+1 .' - '.TextFormatService::ucfirst($correlativa->asignatura->nombre);
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
            foreach($asignatura->correlativas as $correlativa){
                $aprobado = Asignatura::where('asignaturas.id',$correlativa->asignatura_correlativa)
                    -> join('cursadas', 'cursadas.id_asignatura','asignaturas.id')
                    -> join('examenes', 'examenes.id_asignatura','asignaturas.id')
                    -> where('cursadas.id_alumno', Auth::id()) -> where('cursadas.aprobada', 1)
                    -> first();

                if(!$aprobado) return redirect()->back()->with('error', 'Debes 1 o mas correlativas');
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
                'condicion' => $tipoCursada,
                'aprobada' => 3,
                'anio_cursada' => $anio_remat
            ]);
        }
        return redirect()->back()->with('mensaje','Te has rematriculado correctamente');       
    }

    function bajar_rematriculacion(Request $request, Cursada $cursada){
        if($cursada->aprobada != 3) return redirect()->back()->with('error','Ya has terminado de cursar');
        
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
