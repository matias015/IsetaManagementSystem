<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\crearAlumnoRequest;
use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoCrudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {       
         $alumnos = [];
         $filtro = "";
         $porPagina = 15;

        if($request->has('filtro')){
            $filtro = $request->filtro;

            if(strpos($filtro, ':')){
                $arr = explode(':',$filtro);
                $campo = $arr[0];
                $keyword = $arr[1];
                $alumnos = Alumno::where($campo,'LIKE','%'.$keyword.'%')-> paginate($porPagina);
            }else{
                
                $alumnos = Alumno::where('nombre','LIKE','%'.$filtro.'%')
                    -> orWhere('apellido','LIKE',$filtro)
                    -> orWhere('dni','LIKE',$filtro)
                    -> orWhere('email','LIKE',$filtro)
                    -> paginate($porPagina);
            }   
        }else{
            $alumnos = Alumno::paginate($porPagina);
        }
        return view('Admin.Alumnos.index',['alumnos'=>$alumnos, 'filtro'=>$filtro]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Alumnos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(crearAlumnoRequest $request)
    {
        $data = $request->validated();

        Alumno::create($data);
        return redirect()->route('admin.alumnos.index');
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
    public function edit(Alumno $alumno)
    {
        //dd($alumno->fecha_nacimiento);
        return view('Admin.Alumnos.edit', compact('alumno'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alumno $alumno)
    {
        $alumno->update($request->all());
        return redirect()->route('admin.alumnos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumno $alumno)
    {
        $alumno->delete();
        return redirect() -> route('admin.alumnos.index') -> with('mensaje', 'Se ha eliminado el alumno');
    }
}
