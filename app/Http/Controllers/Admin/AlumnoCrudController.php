<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\crearAlumnoRequest;
use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoCrudController extends Controller
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
         $alumnos = [];
         $filtro = "";
         $campo = "";
         $porPagina = 15;

        if($request->has('filtro')){
            $filtro = $request->filtro;
            $campo = $request->campo;

            if($campo == "principales"){
                $alumnos = Alumno::where('nombre','LIKE','%'.$filtro.'%')
                    -> orWhere('apellido','LIKE','%'.$filtro.'%')
                    -> orWhere('dni','LIKE','%'.$filtro.'%')
                    -> orWhere('email','LIKE','%'.$filtro.'%')
                    -> paginate($porPagina);
            }
            else if($campo == "nombre") $alumnos = Alumno::where('nombre','LIKE','%'.$filtro.'%') -> paginate($porPagina);  
            else if($campo == "apellido") $alumnos = Alumno::where('apellido','LIKE','%'.$filtro.'%') -> paginate($porPagina);  
            else if($campo == "dni") $alumnos = Alumno::where('dni','LIKE','%'.$filtro.'%') -> paginate($porPagina);  
            else if($campo == "email") $alumnos = Alumno::where('email','LIKE','%'.$filtro.'%') -> paginate($porPagina);  
            else if($campo == "telefonos"){
                $alumnos = Alumno::where('telefono1','LIKE','%'.$filtro.'%')
                    -> orWhere('telefono2','LIKE','%'.$filtro.'%')
                    -> orWhere('telefono3','LIKE','%'.$filtro.'%')
                    -> paginate($porPagina);  
            } 
            else if($campo == "ciudad") $alumnos = Alumno::where('email','LIKE','%'.$filtro.'%') -> paginate($porPagina);  
        }else $alumnos = Alumno::paginate($porPagina);
        return view('Admin.Alumnos.index',['alumnos'=>$alumnos, 'filtros'=>['campo'=>$campo,'filtro'=>$filtro]]);
        
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
    public function edit(Request $request, $alumno)
    {

        return view('Admin.Alumnos.edit', [
            'alumno' => Alumno::where('id', $alumno)->with('cursadas.asignatura.carrera','examenes.mesa.materia.carrera')->first()
        ]);
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
