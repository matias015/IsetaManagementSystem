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
        $filtro = $request->filtro ? $request->filtro: '';
        $campo = $request->campo ? $request->campo: '';
        $orden = $request->orden ? $request->orden: 'fecha';
        $porPagina = 15;

        $query = Alumno::select('alumnos.id','alumnos.nombre','alumnos.apellido','alumnos.dni');

            if($campo == "nombre-apellido"){
                $query = $query 
                    -> where('nombre','LIKE','%'.$filtro.'%')
                    -> orWhere('apellido','LIKE','%'.$filtro.'%');
            }
            else if($campo == "dni"){
                $query = $query -> where('dni','LIKE','%'.$filtro.'%');
            }
            else if($campo == "email"){
                $query = $query -> where('email','LIKE','%'.$filtro.'%');
            }
            else if($campo == "cursando"){
                $query = $query -> join('cursadas','alumnos.id','cursadas.id_alumno')
                    -> join('asignaturas', 'asignaturas.id','cursadas.id_asignatura')
                    -> where('cursadas.aprobada', 3)
                    -> where('asignaturas.nombre','LIKE','%'.$filtro.'%');
            }
            else if($campo == "registrados"){
                $query = $query -> where('verificado','!=','0');
            }

            if($orden == "nombre"){
                $query = $query -> orderBy('alumnos.nombre');
            }
            else if($orden == "dni"){
                $query = $query -> orderBy('dni');
            }
            else if($orden == "dni-desc"){
                $query = $query -> orderByDesc('dni');
            }

            $alumnos = $query->paginate($porPagina); 

        return view('Admin.Alumnos.index',[
            'alumnos'=>$alumnos, 
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
        $alumno = Alumno::where('id', $alumno)->with('cursadas.asignatura.carrera','examenes.mesa.materia.carrera')->first();
        //dd($alumno->id);
        return view('Admin.Alumnos.edit', [
            'alumno' => $alumno
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
