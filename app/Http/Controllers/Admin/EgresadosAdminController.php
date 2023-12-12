<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\crearAlumnoRequest;
use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\Configuracion;
use App\Models\Egresado;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class EgresadosAdminController extends Controller
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

        $alumnos = [];
        
        $filtro = $request->filtro ? $request->filtro: '';
        $campo = $request->campo ? $request->campo: '';
        $orden = $request->orden ? $request->orden: 'fecha';
        $porPagina = $config['filas_por_tabla'];
        
        
        $query = Egresado::select('egresadoinscripto.id as id','alumnos.id as id_alumno','alumnos.nombre','alumnos.apellido','alumnos.dni','carreras.nombre as carrera','egresadoinscripto.anio_inscripcion','egresadoinscripto.anio_finalizacion')
        ->join('alumnos','alumnos.id','egresadoinscripto.id_alumno')
        ->join('carreras','carreras.id','egresadoinscripto.id_carrera');

        
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
        }else if($campo == "egresados"){
            $query = $query -> where('anio_finalizacion','!=','null');
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

        return view('Admin.inscriptos.index',[
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
        return view('Admin.inscriptos.create',[
            'alumnos'=>Alumno::orderBy('apellido')->orderBy('nombre')->get(),
            'carreras'=>Carrera::where('vigente','1')->get()
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
            'indice_libro_matriz' => ['nullable'],
            'anio_finalizacion' => ['nullable']
        ]);
        
        Egresado::create($data);
        return redirect()->route('admin.inscriptos.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $registro)
    { 
        $registro = Egresado::find($registro);
        if(!$registro) return \redirect()->route('admin.inscriptos.index')->with('aviso','La inscripcion no existe');

       
        return view('Admin.inscriptos.edit', [
            'registro' => $registro,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $registro)
    {
        $registro = Egresado::find($registro);
        $registro->update($request->all());
        return redirect()->back()->with('mensaje','Se actulizo correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($alumno)
    {
        Egresado::find($alumno)->delete();
        return redirect() -> route('admin.inscriptos.index') -> with(['mensaje' => [
            'Se ha eliminado la inscripcion',
            'Recuerda que puedes volver a crearla en el apartado "crear inscripcion"'
        ]]);
    }
}
