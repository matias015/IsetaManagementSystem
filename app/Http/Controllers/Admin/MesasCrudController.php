<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asignatura;
use App\Models\Mesa;
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

            if(strpos($filtro, ':')){
                $arr = explode(':',$filtro);
                $campo = $arr[0];
                $keyword = $arr[1];
                $mesas = Mesa::where($campo,'LIKE','%'.$keyword.'%')-> paginate($porPagina);
            }else{
                $mesas = Mesa::select('mesa.id','mesa.fecha', 'asignaturas.nombre','asignaturas.anio', 'carrera.nombre as carrera')
                    ->join('asignaturas','asignaturas.id','=','mesa.id_asignatura')
                    ->join('carrera','carrera.id','=','asignaturas.id_carrera')
                    ->where('asignaturas.nombre','LIKE','%'.$filtro.'%')
                    ->paginate($porPagina);
            }   
        }else{
            $mesas = Mesa::paginate($porPagina);
        }
        //dd($mesas);
        return view('Admin.Mesas.index',['mesas'=>$mesas, 'filtro'=>$filtro]);
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
        //dd($alumno->fecha_nacimiento);
        return view('Admin.Alumnos.edit', [
            'alumno' => Alumno::where('id', $alumno)->with('cursadas.asignatura.carrera')->first()
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
