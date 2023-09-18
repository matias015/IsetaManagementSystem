<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrearMesaRequest;
use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Carrera;
use App\Models\Configuracion;
use App\Models\Examen;
use App\Models\Habiles;
use App\Models\Mesa;
use App\Models\Profesor;
use App\Services\DiasHabiles;
use Illuminate\Http\Request;

class MesasCrudController extends Controller

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
        $mesas = [];
        $filtro = $request->filtro ? $request->filtro: '';
        $campo = $request->campo ? $request->campo: '';
        $orden = $request->orden ? $request->orden: 'fecha';
        $porPagina = Configuracion::get('filas_por_tabla',true);

        $query = Mesa::select('mesas.id','mesas.llamado','mesas.fecha', 'asignaturas.nombre','asignaturas.anio', 'carreras.nombre as carrera')
            -> join('asignaturas','asignaturas.id','=','mesas.id_asignatura')
            -> join('carreras','carreras.id','=','asignaturas.id_carrera');

        if($campo == "proximas"){
            $query = $query->whereRaw('fecha > NOW()');
        }

        if($orden == "fecha"){
            $query->orderByDesc('mesas.fecha');
        }
        else if($orden == "asignatura"){
            $query->orderBy('asignaturas.nombre');
        }

        if($filtro){
            $word = '%'.str_replace(' ','%',$filtro).'%';
            $query->whereRaw("(asignaturas.nombre LIKE '$word' OR carreras.nombre LIKE '$word')");
        }

        $mesas = $query -> paginate($porPagina);
        
        //dd($mesas);
        return view('Admin.Mesas.index',[
            'mesas' => $mesas, 
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
        $carreras = Carrera::where('vigente', 1)->get();
        $profesores = Profesor::orderBy('nombre','asc')->orderBy('apellido','asc')->get();
        return view('Admin.Mesas.create',['carreras'=>$carreras,'profesores'=>$profesores]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CrearMesaRequest $request)
    {
        $data = $request->validated();

        $timestamp = strtotime($data['fecha']);
        $dia = date("l", $timestamp);


        if($dia == 'Saturday' || $dia == 'Sunday'){
            return \redirect()->back()->with('error','No puedes crear una mesa un fin de semana');
        }

        $diasNoHabiles = DiasHabiles::obtenerFestivos();

        if(in_array(explode('T', $data['fecha'])[0],$diasNoHabiles)){
            return \redirect()->back()->with('error','No puedes crear una mesa un dia no habil');
        }

        if($data['prof_presidente']=="vacio"){
            $data['prof_presidente'] = 0;
        }
        if($data['prof_vocal_1']=="vacio"){
            $data['prof_vocal_1'] = 0;
        }
        if($data['prof_vocal_2']=="vacio"){
            $data['prof_vocal_2'] = 0;
        }
        $data['id_carrera'] = Asignatura::find($data['id_asignatura'])->carrera->id;
        Mesa::create($data);
        return redirect()->route('admin.mesas.index');
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
    public function edit(Request $request, $mesa)
    {
        $mesa = Mesa::where('id', $mesa)->with('materia.carrera','profesor','vocal1','vocal2')->first();

        $profesores = Profesor::all();

        $alumnos = Mesa::select('examenes.id as id_examen','alumnos.nombre','alumnos.apellido','examenes.nota')
            -> join('examenes', 'examenes.id_mesa','mesas.id')
            -> join('alumnos', 'alumnos.id','examenes.id_alumno')
            -> where('mesas.id', $mesa->id)
            -> get();

        $inscribibles = Alumno::select('alumnos.id','alumnos.nombre', 'alumnos.apellido')
            -> join('cursadas','cursadas.id_alumno','alumnos.id')
            -> join('asignaturas','asignaturas.id','cursadas.id_asignatura')
            -> where('cursadas.aprobada','1')
            -> where('cursadas.id_asignatura',$mesa->id_asignatura)
            -> get();

           

        return view('Admin.Mesas.edit', [
            'mesa' => $mesa,
            'alumnos' => $alumnos,
            'profesores'=>$profesores,
            'inscribibles' => $inscribibles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mesa $mesa)
    {
        //CAMIAR REQUEST ALL
        $data = $request->all();

        if($data['prof_presidente']=="vacio"){
            $data['prof_presidente'] = 0;
        }
        if($data['prof_vocal_1']=="vacio"){
            $data['prof_vocal_1'] = 0;
        }
        if($data['prof_vocal_2']=="vacio"){
            $data['prof_vocal_2'] = 0;
        }
        $mesa->update($data);
        
        return redirect()->route('admin.mesas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mesa $mesa)
    {
        Examen::where('id_mesa',$mesa->id)->where('nota',0)->delete();
        $mesa->delete();
        return redirect() -> route('admin.mesas.index') -> with('mensaje', 'Se ha eliminado la mesa');
    }
}
