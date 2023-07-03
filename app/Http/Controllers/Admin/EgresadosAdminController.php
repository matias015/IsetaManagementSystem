<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\crearAlumnoRequest;
use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\Configuracion;
use App\Models\Egresado;
use Illuminate\Http\Request;

class EgresadosAdminController extends Controller
{
    public function __construct()
    {
       // $this -> middleware('guest');
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
        $porPagina = Configuracion::get('filas_por_tabla',true);

        $query = Egresado::select('alumnos.id','alumnos.nombre','alumnos.apellido','alumnos.dni','carreras.nombre as carrera')
                ->join('alumnos','alumnos.id','egresadoinscripto.id_alumno')
                ->join('carreras','carreras.id','egresadoinscripto.id_carrera');

            if($campo == "nombre-apellido"){
                $query = $query 
                    -> where('alumnos.nombre','LIKE','%'.$filtro.'%')
                    -> orWhere('alumnos.apellido','LIKE','%'.$filtro.'%');
            }
            else if($campo == "dni"){
                $query = $query -> where('alumnos.dni','LIKE','%'.$filtro.'%');
            }
            else if($campo == "email"){
                $query = $query -> where('alumnos.email','LIKE','%'.$filtro.'%');
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

           if($orden == "dni"){
                $query = $query -> orderBy('alumnos.dni');
            }
            else if($orden == "dni-desc"){
                $query = $query -> orderByDesc('alumnos.dni');
            } else{
                $query = $query -> orderBy('alumnos.nombre') -> orderBy('alumnos.apellido');
            }

            $alumnos = $query->paginate($porPagina); 

        return view('Admin.Egresados.index',[
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
        return view('Admin.Egresados.create',[
            'alumnos'=>Alumno::all(),
            'carreras'=>Carrera::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_alumno' => ['required'],
            'id_carrera' => ['required'],
            'anio_inscripcion' => ['required'],
            'indice_libro_matriz' => ['required'],
            'anio_finalizacion' => ['required']
        ]);
        
        Egresado::create($data);
        return redirect()->route('admin.egresados.index');
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
    public function destroy(Egresado $alumno)
    {
        dd('No hagas cagada');
        $alumno->delete();
        return redirect() -> route('admin.egresados.index') -> with('mensaje', 'Se ha eliminado el alumno');
    }
}
