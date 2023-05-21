<?php


use App\Models\Carrera;
use App\Models\CarreraDefault;
use App\Services\TextFormatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * 
 * acciones del usuario, como:
 *  - ver su informacion
 *  - ver sus cursadas
 *  - anotarse/bajarse de mesas
 *  - etc
 * 
 */

class AlumnoController extends Controller
{

    /**
     * todas las rutas estan protegidas
     */
    public function __construct()
    {
        $this -> middleware('auth:web');
    }

    /**
     * setea la carrera que el alumno haya elegido como default para los resultados
     * se guarda en la tabla: carreras_default
     */
    function setCarreraDefault(Request $request){
        $data = [
            'id_alumno' => Auth::id(),
            'id_carrera' => $request -> carrera
        ];

        CarreraDefault::updateOrInsert($data);
        return redirect()->back();
    }

    /**
     * informacion genereal del alumno
     * y un select para elegir una carrera default
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
            'default' => Carrera::getDefault(),

            //transformar los nombres de las carreras a utf-8
            'textFormatService' => new TextFormatService()
        ]);
    }

    /**
     * ver todas las cursadas del alumno y su estado
     */
    function cursadas(){
        $user = Auth::user();

        $cursadas = $user->cursadas()->with('materia')->get();

        // lista de examenes aprobados para saber si una cursada
        // tiene rendido su final
        $examenesAprobados = DB::table('examenes')
            -> join('mesa','examenes.id_mesa','mesa.id')
            -> select('mesa.id_asignatura')
            -> where('examenes.nota','>=',4)
            -> where('examenes.id_alumno',Auth::id())
            -> get()
            -> pluck('id_asignatura')
            -> toArray();
    
        return view('Alumnos.Datos.cursadas', ['cursadas'=>$cursadas, 'examenesAprobados'=>$examenesAprobados]);
    }
}
