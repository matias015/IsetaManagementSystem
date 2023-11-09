<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Carrera;
use App\Models\Configuracion;
use App\Models\Cursada;
use App\Repositories\CursadaRepository;
use Illuminate\Http\Request;

class CursadasAdminController extends Controller
{
        function __construct()
    {
        $this -> middleware('auth:admin');
    }

    public function index(Request $request, CursadaRepository $cursadas)
    {       
        $filtro = $request->filtro ? $request->filtro: '';
        $campo = $request->campo ? $request->campo: '';
        $orden = $request->orden ? $request->orden: 'fecha';

        $cursadas = $cursadas->conFiltros($filtro,$campo,$orden);
        
        return view('Admin.Cursadas.index', [
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
