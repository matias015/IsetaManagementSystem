<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\crearAlumnoRequest;
use App\Http\Requests\EditarAlumnoRequest;
use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\Configuracion;
use App\Models\Cursada;
use App\Models\Egresado;
use App\Models\Examen;
use Hamcrest\Type\IsNumeric;
use Illuminate\Http\Request;

class AlumnoCrudController extends Controller
{
    function __construct()
    {
        // $this -> middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $config = Configuracion::todas();    

        $alumnos = [];
        $filtro = $request->filtro ? $request->filtro: '';
        $campo = $request->campo ? $request->campo: '';
        $orden = $request->orden ? $request->orden: 'fecha';
        $porPagina = $config['filas_por_tabla'];
        
        $query = Alumno::select('alumnos.id','alumnos.nombre','alumnos.apellido','alumnos.dni');


        if($filtro){
            if(is_numeric($filtro)){
                $query = $query->where('alumnos.dni','like','%'.$filtro.'%');
            }  
            else if(preg_match('/^[a-zA-Z\s]+$/', $filtro)){
                $word = str_replace(' ','%',$filtro);
                $query->orWhereRaw("(CONCAT(alumnos.nombre,' ',alumnos.apellido) LIKE '%$word%' OR alumnos.email  LIKE '%$word%')");
            }else{
                $query = $query->where('alumnos.email', 'LIKE', '%'.$filtro.'%');
            }
        }
        
        
       
        if($campo == "registrados"){
            $query = $query -> where('password','!=','0');
        }

        if($orden == "dni"){
            $query = $query -> orderBy('dni');
        }
        else if($orden == "dni-desc"){
            $query = $query -> orderByDesc('dni');
        } else{
            $query = $query -> orderBy('alumnos.nombre') -> orderBy('alumnos.apellido');
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
        // $alumno = Alumno::where('id', $alumno)->with('cursadas.asignatura.carrera','examenes.mesa.materia.carrera')->first();
        $alumno = Alumno::find($alumno);
        $cursadas = Cursada::select('asignaturas.nombre as asignatura', 'cursadas.aprobada' ,'cursadas.condicion' ,'cursadas.anio_cursada' ,'cursadas.id' ,'carreras.nombre as carrera','asignaturas.anio as anio_asig')
            ->join('asignaturas', 'cursadas.id_asignatura','asignaturas.id')
            -> join('carreras','carreras.id','asignaturas.id_carrera')
            -> where('cursadas.id_alumno',$alumno->id)
            -> orderBy('carreras.id')
            -> orderBy('asignaturas.anio')
            -> orderBy('asignaturas.id')
            -> orderBy('cursadas.anio_cursada')
            -> get();

            $examenes = Examen::select('examenes.fecha','asignaturas.nombre as asignatura', 'examenes.nota' ,'examenes.id' ,'carreras.nombre as carrera','asignaturas.anio as anio_asig')
            ->join('asignaturas', 'examenes.id_asignatura','asignaturas.id')
            -> join('carreras','carreras.id','asignaturas.id_carrera')
            -> where('examenes.id_alumno',$alumno->id)
            -> orderBy('carreras.id')
            -> orderBy('asignaturas.anio')
            -> orderBy('asignaturas.id')
            -> orderBy('examenes.fecha')
            -> get();
        // \dd($cursadas);

        return view('Admin.Alumnos.edit', [
            'alumno' => $alumno,
            'cursadas' => $cursadas,
            'examenes' => $examenes,
            'carreras' => Carrera::vigentes()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditarAlumnoRequest $request, Alumno $alumno)
    {
        $alumno->update($request->validated());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumno $alumno)
    {
        return redirect()->back()->with('error','De momento, no se pueden eliminar alumnos');
        
        $alumno->delete();
        return redirect() -> route('admin.alumnos.index') -> with('mensaje', 'Se ha eliminado el alumno');
    }
}
