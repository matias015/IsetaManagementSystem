<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\crearProfesorRequest;
use App\Models\Profesor;
use Illuminate\Http\Request;

class ProfesoresCrudController extends Controller
{
       /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {       
         $profesores = [];
         $porPagina = 15;

        if($request->has('filtro')){
            
            if(strpos($request->filtro,':')){
                $arr = explode(':',$request->filtro);
                $campo = $arr[0];
                $filtro = $arr[1];
                $profesores = Profesor::where($campo,'LIKE','%'.$filtro.'%')-> paginate($porPagina);
            }else{

                $filtro = '%'.$request->filtro.'%';
                

                $profesores = Profesor::where('nombre','LIKE',$filtro)
                    -> orWhere('apellido','LIKE',$filtro)
                    -> orWhere('dni','LIKE',$filtro)
                    -> orWhere('email','LIKE',$filtro)
                    -> paginate($porPagina);
            }   
        }else{
            $profesores = Profesor::paginate($porPagina);
        }
        return view('Admin.Profesores.index',compact('profesores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.profesores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(crearProfesorRequest $request)
    {
        $data = $request->validated();

        Profesor::create($data);
        return redirect()->route('admin.profesores.index');
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
    public function edit(Profesor $profesor)
    {
        //dd($profesor->fecha_nacimiento);
        return view('admin.profesores.edit', compact('profesor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profesor $profesor)
    {
        $profesor->update($request->all());
        return redirect()->route('admin.profesores.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profesor $profesor)
    {
        $profesor->delete();
        return redirect() -> route('admin.profesores.index') -> with('mensaje', 'Se ha eliminado el alumno');
    }
}
