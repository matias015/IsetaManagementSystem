<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrearCarreraRequest;
use App\Http\Requests\EditarCarreraRequest;
use App\Models\Carrera;
use App\Models\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarrerasCrudController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {       
         $carreras = [];
         $config = Configuracion::todas();
        //  \dd($request->all());

         $filtro = $request->filtro ? $request->filtro: '';
         $campo = $request->campo ? $request->campo: 'vigentes';
         $orden = $request->orden ? $request->orden: 'fecha';
         $porPagina = $config['filas_por_tabla'];

         $query = Carrera::select('*');

         if($filtro){
            $word = str_replace(' ','%',$filtro);
            $query->orWhere('carreras.nombre', 'LIKE', '%'.$word.'%');
        }

        if($campo == "vigentes"){
            $query -> where('vigente','1');
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

        $data['vigente'] = 1;

        Carrera::create($data);
        return redirect()->route('admin.carreras.index');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,Carrera $carrera)
    {
        
        
        return view('Admin.Carreras.edit', ['carrera'=>Carrera::where('id',$carrera->id)->with('asignaturas')->first()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditarCarreraRequest $request, Carrera $carrera)
    {
        $datos = $request->validated();

        if($request->has('resolucion_archivo')){
            $request->file('resolucion_archivo')->storeAs(str_replace(' ','_',$datos['nombre']).'.pdf');
            $datos['resolucion_archivo'] = str_replace(' ','_',$datos['nombre']).'.pdf';
        }


        $carrera->update($datos);

        if(!$request->has('vigente')){
            $carrera->vigente=false;
            $carrera->save();
        }

        return redirect()->back()->with('mensaje','Se edito la carrera');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carrera $carrera)
    {
        return redirect() -> route('admin.carreras.index') -> with('error', 'Las carreras no se pueden eliminar');
    }
}
