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

        
        // if($orden == "fecha"){
        //     $query->orderByDesc('cursadas.fecha');
        // }
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
        $cursada -> update($data);

        $estadoActualPromocion = $cursada->promocionada;

        if($request->has('promocionada') && $request->input('promocionada') == "on"){
            if(!$estadoActualPromocion && $cursada->aprobada != 3){
                return redirect()->back()->with('error','No se puede cambiar el estado de promocion una ves terminada la cursada');
            }

            if(!$cursada->asignatura->promocionable){
                return \redirect()->back()->with('error','Esta asignatura no es promocionable');
            }

            $cursada->promocionada = true;
            $cursada->save();
        }else{
            if($estadoActualPromocion && $cursada->aprobada != 3){
                return redirect()->back()->with('error','No se puede cambiar el estado de promocion una ves terminada la cursada');
            }
            $cursada->promocionada = false;
            $cursada->save();
        }

        return redirect()->back();
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

        dd($puede);

        Cursada::create([
            'id_asignatura' => $request->id_asignatura,
            'id_alumno' => $request->id_alumno,
            'anio_cursada' => $request->anio_cursada,
            'condicion' => $request->condicion
        ]);
        
        return redirect() -> back();
    }
}
