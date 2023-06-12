<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Examen;
use Illuminate\Http\Request;

class ExamenesCrudController extends Controller
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
         $examenes = [];
         $filtro = "";
         $campo = "";
         $porPagina = 15;

        if($request->has('filtro')){
            $filtro = $request->filtro;
            $campo = $request->campo;

            if($campo == "principales"){
                $examenes = Examen::select('examenes.id','alumnos.nombre','alumnos.apellido','asignaturas.nombre as materia','examenes.nota')
                -> join('alumnos','examenes.id_alumno','alumnos.id')
                    -> join('mesas','mesas.id','examenes.id_mesa')
                    -> join('asignaturas', 'asignaturas.id','mesas.id_asignatura')
                    -> where('alumnos.nombre','LIKE','%'.$filtro.'%')
                    -> orWhere('alumnos.apellido','LIKE','%'.$filtro.'%')
                    -> orWhere('alumnos.dni','LIKE','%'.$filtro.'%')
                    -> orWhere('asignaturas.nombre','LIKE','%'.$filtro.'%')
                    -> paginate($porPagina);
            }
            else if($campo == "ciudad"||$campo == "email"||$campo == "nombre" || $campo == "apellido" || $campo == "dni") {
                $examenes = Examen::select('examenes.id','alumnos.nombre','alumnos.apellido','asignaturas.nombre as materia','examenes.nota')
                -> join('alumnos','examenes.id_alumno','alumnos.id')
                -> join('mesas','mesas.id','examenes.id_mesa')
                -> join('asignaturas', 'asignaturas.id','mesas.id_asignatura')
                -> where('alumnos.'.$campo.'','LIKE','%'.$filtro.'%')
                -> paginate($porPagina);
            }
            else if($campo == "telefonos"){
                $examenes = Examen::select('examenes.id','alumnos.nombre','alumnos.apellido','asignaturas.nombre as materia','examenes.nota')
                -> join('alumnos','examenes.id_alumno','alumnos.id')
                -> join('mesas','mesas.id','examenes.id_mesa')
                -> join('asignaturas', 'asignaturas.id','mesas.id_asignatura')
                -> where('alumnos.telefono1','LIKE','%'.$filtro.'%')
                -> orWhere('alumnos.telefono2','LIKE','%'.$filtro.'%')
                -> orWhere('alumnos.telefono3','LIKE','%'.$filtro.'%')
                -> paginate($porPagina);
            } 
            else if($campo == "materia"){
                $examenes = Examen::select('examenes.id','alumnos.nombre','alumnos.apellido','asignaturas.nombre as materia','examenes.nota')
                -> join('alumnos','examenes.id_alumno','alumnos.id')
                -> join('mesas','mesas.id','examenes.id_mesa')
                -> join('asignaturas', 'asignaturas.id','mesas.id_asignatura')
                -> where('asignaturas.nombre','LIKE','%'.$filtro.'%')
                -> paginate($porPagina);
            } 
        }else{
            $examenes = Examen::select('examenes.id','alumnos.nombre','alumnos.apellido','asignaturas.nombre as materia','examenes.nota')
                -> join('alumnos','examenes.id_alumno','alumnos.id')
                -> join('mesas','mesas.id','examenes.id_mesa')
                -> join('asignaturas', 'asignaturas.id','mesas.id_asignatura')
                -> paginate($porPagina);
        }
        
        return view('Admin.Examenes.index',['examenes'=>$examenes, 'filtros'=>['campo'=>$campo,'filtro'=>$filtro]]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Examenes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->only('');

        Examen::create($data);
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
    public function destroy(Examen $examen)
    {
        $examen->delete();
        return redirect() -> back() -> with('mensaje', 'Se ha eliminado el alumno');
    }
}
