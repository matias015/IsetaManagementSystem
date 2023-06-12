<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrearMesaRequest;
use App\Models\Asignatura;
use App\Models\Carrera;
use App\Models\Mesa;
use App\Models\Profesor;
use Illuminate\Http\Request;

class MesasCrudController extends Controller

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
        $mesas = [];
        $filtro = $request->filtro ? $request->filtro: '';
        $campo = $request->campo ? $request->campo: '';
        $orden = $request->orden ? $request->orden: 'fecha';
        $porPagina = 15;

        $query = Mesa::select('mesas.id','mesas.fecha', 'asignaturas.nombre','asignaturas.anio', 'carreras.nombre as carrera')
            -> join('asignaturas','asignaturas.id','=','mesas.id_asignatura')
            -> join('carreras','carreras.id','=','asignaturas.id_carrera');

        if($campo == "nuevas"){
            $query = $query->whereRaw('fecha > NOW()');
        }
        else if($campo == "asignatura"){
            $query = $query->where('asignaturas.nombre','LIKE','%'.$request->filtro.'%'); 
        }
        else if($campo == "carrera"){
            $query = $query->where('carreras.nombre','LIKE','%'.$request->filtro.'%'); 
        }

        
        if($orden == "fecha"){
            $query->orderByDesc('mesas.fecha');
        }
        else if($orden == "asignatura"){
            $query->orderBy('asignaturas.nombre');
        }

        $mesas = $query -> paginate($porPagina);
        
        //dd($mesas);
        return view('Admin.Mesas.index',[
            'mesas' => $mesas, 
            'filtros'=>[
                'campo' => $campo,
                'orden' => $orden,
                'filtro' => $filtro
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $carreras = Carrera::all();
        $profesores = Profesor::all();
        return view('Admin.Mesas.create',['carreras'=>$carreras,'profesores'=>$profesores]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CrearMesaRequest $request)
    {
        $data = $request->validated();

        Mesa::create($data);
        return redirect()->route('admin.mesas.index');
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
    public function edit(Request $request, $mesa)
    {
        $alumnos = Mesa::select('examenes.id as id_examen','alumnos.nombre','alumnos.apellido','examenes.nota')
            -> join('examenes', 'examenes.id_mesa','mesas.id')
            -> join('alumnos', 'alumnos.id','examenes.id_alumno')
            -> where('mesas.id', $mesa)
            -> get();


        return view('Admin.Mesas.edit', [
            'mesa' => Mesa::where('id', $mesa)->with('materia.carrera')->first(),
            'alumnos' => $alumnos
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mesa $mesa)
    {
        $mesa->update($request->all());
        return redirect()->route('admin.mesas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mesa $mesa)
    {
        $mesa->delete();
        return redirect() -> route('admin.mesas.index') -> with('mensaje', 'Se ha eliminado el alumno');
    }
}
