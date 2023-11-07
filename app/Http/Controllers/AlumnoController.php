<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\CarreraDefault;
use App\Models\Configuracion;
use App\Models\Cursada;
use App\Models\Egresado;
use App\Models\Examen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AlumnoController extends Controller
{

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
        return view('Alumnos.Datos.informacion', [
            'alumno'=>Auth::user(),
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
        if(!Egresado::estaInscripto($request->input('carrera'))){
            return redirect()->back()->with('error','No estas inscripto en esta carrera');
        }

        $data = [
            'id_alumno' => Auth::id(),
            'id_carrera' => $request->carrera
        ];

        CarreraDefault::updateOrInsert(['id_alumno' => Auth::id()],$data);     
        return redirect()->back()->with('mensaje','Se ha seleccionado esa asignatura');
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
        
        // cursadas del alumno de la carrera seleccionada
        $query = Cursada::with('asignatura')->select('cursadas.id_asignatura','cursadas.anio_cursada','cursadas.id','cursadas.aprobada','cursadas.condicion','asignaturas.nombre','asignaturas.anio')
            -> where('id_alumno', Auth::id())
            -> where('asignaturas.id_carrera', Carrera::getDefault(Auth::id())->id) 
            -> join('asignaturas','asignaturas.id','cursadas.id_asignatura');

        if($request->has('filtro')){
            $query =  $query -> where('asignaturas.nombre','LIKE','%'.$filtro.'%');
        }

        if($campo == "aprobadas"){
            $query->where(function($sub){
                $sub -> where('cursadas.aprobada', 1)
                    ->orWhereIn('cursadas.condicion',[0,2,3]);
            });
        }

        else if($campo == "desaprobadas"){
            $query-> where('cursadas.aprobada', 2)
                ->whereNotIn('cursadas.condicion',[0,2,3]);
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
        
        return view('Alumnos.Datos.cursadas', [
            'cursadas' => $cursadas, 
            'examenesAprobados' => $examenesAprobados,
            'puedeBajarse' => Configuracion::puedeDesinscribirCursada(),
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
        
        $examenes = Examen::join('asignaturas', 'asignaturas.id','examenes.id_asignatura')
        -> where('asignaturas.id_carrera', Carrera::getDefault()->id)
        -> where('examenes.id_alumno', Auth::id())
        -> orderBy('asignaturas.anio')
        -> orderBy('asignaturas.id')
        -> orderBy('examenes.fecha')
        -> orderBy('examenes.nota','desc')
        -> get();

        
            // \dd($examenes);
        return view('Alumnos.Datos.examenes', [
            'examenes'=>$examenes,
            // 'promedio'=>$promedio,
            'filtros'=>[
                'campo' => $campo,
                'orden' => $orden,
                'filtro' => $filtro
            ]
        ]);
    }

}
