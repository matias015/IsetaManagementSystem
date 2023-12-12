<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\crearProfesorRequest;
use App\Models\Configuracion;
use App\Models\Mesa;
use App\Models\Profesor;
use Illuminate\Http\Request;

class ProfesoresCrudController extends Controller
{
        function __construct()
    {
        $this -> middleware('auth:admin');
    }
       /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {       
        $config = Configuracion::todas();    

        $profesores = [];
        $filtro = $request->filtro ? $request->filtro: '';
        $campo = $request->campo ? $request->campo: '';
        $orden = $request->orden ? $request->orden: 'fecha';
        $porPagina = $config['filas_por_tabla'];

        $query = Profesor::select('profesores.email','profesores.id','profesores.nombre','profesores.apellido','profesores.dni');


        if($filtro){
            if(is_numeric($filtro)){
                $query = $query->where('profesores.dni','like','%'.$filtro.'%');
            }  
            else if(preg_match('/^[a-zA-Z\s]+$/', $filtro)){
                $word = str_replace(' ','%',$filtro);
                $query->orWhereRaw("CONCAT(profesores.nombre,' ',profesores.apellido) LIKE '%$word%'");            
            }else{
                $query = $query->where('profesores.email', 'LIKE', '%'.$filtro.'%');
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
                $query = $query -> orderBy('profesores.nombre') -> orderBy('profesores.apellido');
            }

            $profesores = $query->paginate($porPagina); 
        return view('Admin.Profesores.index',[
            'profesores'=>$profesores, 
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
        return view('admin.profesores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(crearProfesorRequest $request)
    {
        $data = $request->validated();

        Profesor::create($data);
        return redirect()->route('admin.profesores.index')->with('mensaje','Se creo el profesor');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profesor $profesor)
    {
        //dd($profesor->fecha_nacimiento);
        $mesas = Mesa::where(function ($query) use ($profesor) {
            $query->where('prof_presidente', $profesor->id)
                ->orWhere('prof_vocal_1', $profesor->id)
                ->orWhere('prof_vocal_2', $profesor->id);
        })
        ->whereRaw('fecha > NOW()')
        ->get();

        return view('admin.profesores.edit', [
            'profesor' => $profesor,
            'mesas' => $mesas
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profesor $profesor)
    {
        $profesor->update($request->all());
        return redirect()->route('admin.profesores.index')->with('mensaje','Se edito el profesor');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profesor $profesor)
    {
        $profesor->delete();
        return redirect() -> route('admin.profesores.index') -> with('mensaje', 'Se ha eliminado el profesor');
    }
}
