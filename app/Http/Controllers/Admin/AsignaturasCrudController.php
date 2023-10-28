<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrearAsignaturaRequest;
use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Carrera;
use App\Models\Configuracion;
use Illuminate\Http\Request;
use Svg\Tag\Rect;

class AsignaturasCrudController extends Controller
{
    
    function __construct()
    {
        $this -> middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {       
         $asignaturas = [];
         $filtro = "";
         $porPagina = Configuracion::get('filas_por_tabla',true);


        if($request->has('filtro')){
            $filtro = $request->filtro;

            if(strpos($filtro, ':')){
                $arr = explode(':',$filtro);
                $campo = $arr[0];
                $keyword = $arr[1];
                $asignaturas = Asignatura::where($campo,'LIKE','%'.$keyword.'%') -> paginate($porPagina);
            }else{
                
                $asignaturas = Asignatura::where('nombre','LIKE','%'.$filtro.'%')
                    -> paginate($porPagina);
            }   
        }else{
            $asignaturas = Asignatura::select('*')->with('carrera')->paginate($porPagina);
        }
        return view('Admin.Asignaturas.index',['asignaturas'=>$asignaturas, 'filtro'=>$filtro]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $carreras = Carrera::orderBy('nombre')->get();
        return view('Admin.Asignaturas.create',[
            'carreras'=>$carreras,
            'id_carrera'=>$request->id_carrera? $request->id_carrera:null 
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CrearAsignaturaRequest $request)
    {
        $data = $request->validated();
        if($request->id_carrera){
            $data['id_asignatura'] = $request->id_asignatura; 
        }

        $data['anio'] = $data['anio'] - 1; 

        Asignatura::create($data);
        return redirect()->back()->with('Se creo la asignatura');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $asignatura)
    {
        $config=Configuracion::todas();
        
        // $alumnos = Alumno::select('cursadas.condicion','cursadas.id as cursada_id','alumnos.id','alumnos.nombre','alumnos.apellido','alumnos.dni')
        //     -> join('cursadas','cursadas.id_alumno','alumnos.id')
        //     -> join('asignaturas','cursadas.id_asignatura','asignaturas.id')
        //     -> where('asignaturas.id', $asignatura)
        //     -> where('cursadas.aprobada', 3)
        //     -> where('cursadas.anio_cursada', $config['anio_remat'])
        //     -> get();

            $asignatura = Asignatura::with('cursadas.alumno')->find($asignatura);
            // \dd($asignatura->cursadas);
            $alumnos = $asignatura->cursantes();
            // dd($alumnos);

        return view('Admin.Asignaturas.edit', [
            'asignatura' => $asignatura,
            // 'alumnos' => $alumnos
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asignatura $asignatura)
    {
        $data = $request->all();
        $asignatura->update($data);
        return redirect()->back()->with('mensaje','Se edito la asignatura');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asignatura $asignatura)
    {
        $asignatura->delete();
        return redirect() -> route('admin.carreras.edit',['carrera' => $asignatura->id_carrera]) -> with('mensaje', 'Se ha eliminado la asignatura');
    }
}
