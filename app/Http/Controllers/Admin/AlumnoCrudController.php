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

        if($request->has('filtro')){
            
            if(strpos($request->filtro,':')){
                $arr = explode(':',$request->filtro);
                $campo = $arr[0];
                $filtro = $arr[1];
                $alumnos = Alumno::where($campo,'LIKE','%'.$filtro.'%')-> paginate(25);
            }else{

                $filtro = '%'.$request->filtro.'%';
                

                $alumnos = Alumno::where('nombre','LIKE',$filtro)
                    -> orWhere('apellido','LIKE',$filtro)
                    -> orWhere('dni','LIKE',$filtro)
                    -> orWhere('email','LIKE',$filtro)
                    -> paginate(25);
            }   
        }else{
            $alumnos = Alumno::paginate(25);
        }
        return view('Admin.Alumnos.index',compact('alumnos'));
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
        //dd($data);
        Alumno::create($data);
        return redirect()->route('alumnos.index');
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
        return view('Admin.Alumnos.edit', compact('alumno'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
