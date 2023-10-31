<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Carrera;
use App\Models\Configuracion;
use App\Models\Cursada;
use Illuminate\Http\Request;

class CursadasAdminController extends Controller
{
        function __construct()
    {
        $this -> middleware('auth:admin');
    }

    public function index(Request $request)
    {       
        $cursdas = [];
        $filtro = $request->filtro ? $request->filtro: '';
        $campo = $request->campo ? $request->campo: '';
        $orden = $request->orden ? $request->orden: 'fecha';
        $porPagina = Configuracion::get('filas_por_tabla',true);


        $query = Cursada::select('alumnos.apellido as alumno_apellido','alumnos.nombre as alumno_nombre','cursadas.id','asignaturas.nombre as asignatura','cursadas.aprobada')
            -> join('asignaturas','asignaturas.id','=','cursadas.id_asignatura')
            -> join('carreras','carreras.id','=','asignaturas.id_carrera')
            -> join('alumnos','alumnos.id','=','cursadas.id_alumno');

        
        if($campo == "asignatura"){
            $query = $query->where('asignaturas.nombre','LIKE','%'.$request->filtro.'%'); 
        }
        
        else if($campo == "carrera"){
            $query = $query->where('carreras.nombre','LIKE','%'.$request->filtro.'%'); 
        }

        
        if($filtro){
            if(strpos($filtro,':')){
                $array = explode(':', $filtro);

                $alumno_data = '%'.str_replace(' ','%',$array[1]).'%';
                $asig_nombre = '%'.str_replace(' ','%',$array[0]).'%';
                
                $query->where(function($sub) use($alumno_data,$asig_nombre){
                    $sub->whereRaw("asignaturas.nombre LIKE '$asig_nombre'")
                        ->whereRaw("(CONCAT(alumnos.nombre,' ',alumnos.apellido) LIKE '$alumno_data' OR alumnos.dni LIKE '$alumno_data' OR alumnos.email LIKE '$alumno_data' )");
                });
                $query->orderBy('carreras.nombre');
            }else{
                $word = '%'.str_replace(' ','%',$filtro).'%';
                $query->where(function($sub) use($word){
                    $sub->whereRaw("(asignaturas.nombre LIKE '$word' OR CONCAT(alumnos.nombre,' ',alumnos.apellido) LIKE '$word')");
                });
                $query->orderBy('carreras.nombre');
            }
        }

        if($orden == "creacion"){
            $query->orderBy('cursadas.id','desc');
        }
        else if($orden == "asignatura"){
            $query->orderBy('asignaturas.nombre');
        }

        $cursadas = $query -> paginate($porPagina);
        
        //dd($mesas);
        return view('Admin.Cursadas.index',[
            'cursadas' => $cursadas, 
            'filtros'=>[
                'campo' => $campo,
                'orden' => $orden,
                'filtro' => $filtro
            ]
        ]);
    }
   
    function delete(Cursada $cursada){
        $cursada -> delete();
        return redirect()->back();
    }

    function edit(Request $request, Cursada $cursada){
        //$cursada = Cursada::where('id_asignatura',$asignatura)->where('id_alumno',$alumno)->first();
        return view('Admin.Cursadas.edit',compact('cursada'));
    }

    function update(Request $request, Cursada $cursada){
        $data = $request->except('_token','_method');
        $mensajes = [];

        if( $request->input('condicion') == 0 || 
            $request->input('condicion') == 2 ||
            $request->input('condicion') == 3){
            
                // \dd([$cursada->aprobada, $request->aprobada]);
            
            if($cursada->aprobada == 1 && ($request->aprobada==2 || $request->aprobada==3)){
                $mensajes[] = "No puedes desaprobar una cursada libre, promocionada o aprobada por equivalencias";
            }

            $data['aprobada'] = 1;
        }

        $cursada -> update($data);
        $mensajes[] = 'Se ha editado correctamente';
        
        return redirect()->back()->with('mensaje',$mensajes);
    }

    function create(){
        $alumnos = Alumno::orderBy('nombre','asc')->orderBy('apellido','asc')->get();
        $carreras = Carrera::orderBy('nombre')->get();
        
        return view('Admin/Cursadas/create',[
            'alumnos' => $alumnos,
            'carreras' => $carreras
        ]);
    }

    function store(Request $request){

        // validar si el alumno se puede anotar a la cursada
        // debe tener cursada de equivalencia aprobada
        // no haberla aprobado ya
        // no tener final rendido (no?)

        $puede = true;
        $asignatura = Asignatura::where('id',$request->id_asignatura)->with('correlativas.asignatura')->first(); 

        $cursadasDeEsaMateria = Cursada::where('id_asignatura', $request->id_asignatura)->where('id_alumno', $request->id_alumno)->get();

        foreach($cursadasDeEsaMateria as $cursada){
            if($cursada->aprobada == 1) $puede=false;
        }

        foreach($asignatura->correlativas as $correlativa){
            $cursada = Cursada::where('id_asignatura', $correlativa->asignatura->id)
            -> where('id_alumno', $request->id_alumno)
            -> first();
            if(!$cursada || $cursada->aprobada != 1) $puede = false;  
        }

        // dd($puede);

        Cursada::create([
            'id_asignatura' => $request->id_asignatura,
            'id_alumno' => $request->id_alumno,
            'anio_cursada' => $request->anio_cursada,
            'condicion' => $request->condicion
        ]);
        
        return redirect() -> back();
    }
}
