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
         $filtro = "";
         $porPagina = 15;

        if($request->has('filtro')){
            $filtro = $request->filtro;

            $mesas = Mesa::select('mesas.id','mesas.fecha', 'asignaturas.nombre','asignaturas.anio', 'carreras.nombre as carrera')
                ->join('asignaturas','asignaturas.id','=','mesas.id_asignatura')
                ->join('carreras','carreras.id','=','asignaturas.id_carrera')
                ->where('asignaturas.nombre','LIKE','%'.$filtro.'%')
                ->orWhere('carreras.nombre','LIKE','%'.$filtro.'%')
                ->orderBy('mesas.fecha','ASC')
                ->paginate($porPagina);
        }else{
            $mesas = Mesa::select('mesas.id','mesas.fecha', 'asignaturas.nombre','asignaturas.anio', 'carreras.nombre as carrera')
            ->join('asignaturas','asignaturas.id','=','mesas.id_asignatura')
            ->join('carreras','carreras.id','=','asignaturas.id_carrera')
            ->orderBy('mesas.fecha','DESC')
            ->paginate($porPagina);
        }
        //dd($mesas);
        return view('Admin.Mesas.index',['mesas'=>$mesas, 'filtro'=>$filtro]);
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
    public function edit(Request $request, $carrera)
    {
        //dd($alumno->fecha_nacimiento);
        return view('Admin.Mesas.edit', [
            'mesa' => Mesa::where('id', $carrera)->with('materia.carrera')->first()
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
