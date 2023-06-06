<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrearAsignaturaRequest;
use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Carrera;
use Illuminate\Http\Request;

class AsignaturasCrudController extends Controller
{
    public function __construct()
    {
        $this -> middleware('guest');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {       
         $asignaturas = [];
         $filtro = "";
         $porPagina = 15;

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
    public function create()
    {
        return view('Admin.Asignaturas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CrearAsignaturaRequest $request)
    {
        $data = $request->validated();

        Asignatura::create($data);
        return redirect()->route('admin.asignaturas.index');
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
        

        $alumnos = Alumno::select('alumnos.id','alumnos.nombre','alumnos.apellido','alumnos.dni')
            -> join('cursadas','cursadas.id_alumno','alumnos.id')
            -> join('asignaturas','cursadas.id_asignatura','asignaturas.id')
            -> where('asignaturas.id', $asignatura)
            -> where('cursadas.aprobada', 3)
            -> get();

            

        return view('Admin.Asignaturas.edit', [
            'asignatura' => Asignatura::find($asignatura),
            'alumnos' => $alumnos,
            'carreras' => Carrera::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asignatura $asignatura)
    {
        $asignatura->update($request->all());
        return redirect()->route('admin.asignaturas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asignatura $asignatura)
    {
        $asignatura->delete();
        return redirect() -> route('admin.asignaturas.index') -> with('mensaje', 'Se ha eliminado la asig');
    }
}
