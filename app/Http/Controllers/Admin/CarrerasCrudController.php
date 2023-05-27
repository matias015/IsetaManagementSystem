<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrearCarreraRequest;
use App\Models\Carrera;
use Illuminate\Http\Request;

class CarrerasCrudController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {       
         $carreras = [];
         $porPagina = 15;

        if($request->has('filtro')){
            
            if(strpos($request->filtro,':')){
                $arr = explode(':',$request->filtro);
                $campo = $arr[0];
                $filtro = $arr[1];
                $carreras = Carrera::where($campo,'LIKE','%'.$filtro.'%') -> paginate($porPagina);
            }else{

                $filtro = '%'.$request->filtro.'%';
                

                $carreras = Carrera::where('nombre','LIKE',$filtro)->paginate($porPagina);
            }   
        }else{
            $carreras = Carrera::paginate($porPagina);
        }
        return view('Admin.Carreras.index',compact('carreras'));
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
    public function edit(Carrera $carrera)
    {
        //dd($alumno->fecha_nacimiento);
        return view('Admin.Carreras.edit', compact('carrera'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Carrera $carrera)
    {
        $carrera->update($request->all());
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
