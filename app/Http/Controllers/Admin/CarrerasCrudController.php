<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrearCarreraRequest;
use App\Http\Requests\EditarCarreraRequest;
use App\Models\Carrera;
use App\Models\Configuracion;
use Illuminate\Http\Request;

class CarrerasCrudController extends Controller
{
    
    public function __construct()
    {
      //  $this -> middleware('guest');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {       
         $carreras = [];
         $config = Configuracion::todas();

         $filtro = $request->filtro ? $request->filtro: '';
         $campo = $request->campo ? $request->campo: '';
         $orden = $request->orden ? $request->orden: 'fecha';
         $porPagina = $config['filas_por_tabla'];

         $query = Carrera::select('*');

         if($filtro){
            $word = str_replace(' ','%',$filtro);
            $query->orWhere('carreras.nombre', 'LIKE', '%'.$word.'%');
        }

        if($campo == "vigentes"){
            $query = $query -> where('vigente','1');
        }

        if($orden == "nombre"){
            $query = $query -> orderBy('nombre');
        }
            
        $carreras = $query->paginate($porPagina);

        return view('Admin.Carreras.index',['carreras'=>$carreras, 'filtros'=>[
            'campo' => $campo,
            'orden' => $orden,
            'filtro' => $filtro
        ]]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Carreras.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CrearCarreraRequest $request)
    {
        $data = $request->validated();

        Carrera::create($data);
        return redirect()->route('admin.carreras.index');
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
        //dd(Carrera::where('id',$carrera)->with('asignaturas')->get());
        return view('Admin.Carreras.edit', ['carrera'=>Carrera::where('id',$carrera)->with('asignaturas')->first()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditarCarreraRequest $request, Carrera $carrera)
    {
        $datos = $request->validated();

        $carrera->update($datos);
        return redirect()->route('admin.carreras.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carrera $carrera)
    {
        $carrera->delete();
        return redirect() -> route('admin.carreras.index') -> with('mensaje', 'Se ha eliminado el alumno');
    }
}
