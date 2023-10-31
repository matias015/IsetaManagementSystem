<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrearMesaRequest;
use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Carrera;
use App\Models\Configuracion;
use App\Models\Cursada;
use App\Models\Examen;
use App\Models\Habiles;
use App\Models\Mesa;
use App\Models\Profesor;
use App\Services\DiasHabiles;
use Illuminate\Http\Request;

class MesasCrudController extends Controller

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
        $mesas = [];
        $filtro = $request->filtro ? $request->filtro: '';
        $campo = $request->campo ? $request->campo: '';
        $orden = $request->orden ? $request->orden: 'fecha';

        $porPagina = Configuracion::get('filas_por_tabla',true);

        $query = Mesa::select('mesas.id_asignatura','mesas.id','mesas.llamado','mesas.fecha', 'asignaturas.nombre','asignaturas.anio', 'carreras.nombre as carrera')
            -> join('asignaturas','asignaturas.id','=','mesas.id_asignatura')
            -> join('carreras','carreras.id','=','asignaturas.id_carrera');



        if($campo == "proximas"){
            $query = $query->whereRaw('fecha > NOW()');
        }

        if($orden == "fecha"){
            $query->orderBy('mesas.fecha');
        }
        else if($orden == "asignatura"){
            $query->orderBy('asignaturas.nombre');
        }

        if($filtro){
            if(strpos($filtro,':')){
                $array = explode(':', $filtro);
                $carrera_nombre = $array[0];
                $asig_nombre = $array[1];

                $carrera_nombre = '%'.str_replace(' ','%',$array[0]).'%';
                $asig_nombre = '%'.str_replace(' ','%',$array[1]).'%';
                
                $query->where(function($sub) use($carrera_nombre,$asig_nombre){
                    $sub->whereRaw("(asignaturas.nombre LIKE '$asig_nombre' AND carreras.nombre LIKE '$carrera_nombre')");
                });
                $query->orderBy('carreras.nombre');
            }else{
                $word = '%'.str_replace(' ','%',$filtro).'%';
                $query->where(function($sub) use($word){
                    $sub->whereRaw("(asignaturas.nombre LIKE '$word' OR carreras.nombre LIKE '$word')");
                });
                $query->orderBy('carreras.nombre');
            }
        }

        $query -> orderBy('asignaturas.id')
            -> orderBy('mesas.llamado');

        $mesas = $query -> paginate($porPagina);

        return view('Admin.Mesas.index',[
            'mesas' => $mesas,
            'filtros'=>[
                'campo' => $campo,
                'orden' => $orden,
                'filtro' => $filtro,
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $precargados = [];
        if($request->has('asignatura') && $request->has('carrera')){
            $precargados['carrera'] = $request->input('carrera');
            $precargados['asignatura'] = Asignatura::find($request->input('asignatura'));
        }else{
            $precargados['carrera'] = null;
            $precargados['asignatura'] = null;
        }

        $carreras = Carrera::where('vigente', 1)->get();
        $profesores = Profesor::orderBy('apellido','asc')->orderBy('apellido','asc')->get();
        return view('Admin.Mesas.create',[
            'carreras'=>$carreras,
            'profesores'=>$profesores,
            'precargados' => $precargados
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CrearMesaRequest $request)
    {
        // configuracion
        $config=Configuracion::todas();

        // obtener datos validados
        $data = $request->validated();

        // verificar que no sea sabado ni domingo
        if(DiasHabiles::esFinDeSemana($data['fecha'])){
            return \redirect()->back()->with('error','No puedes crear una mesa un fin de semana');
        }

        // verificar que no sea feriado, o similar
        if(!DiasHabiles::esDiaHabil($data['fecha'])){
            return \redirect()->back()->with('error','No puedes crear una mesa un dia no habil');
        }

        // se añade el id de la carrera al registro de mesa, ya que no viene en el formulario
        // no deberia ser necesario pero la base de datos anterior hacia uso de esta duplicidad
        $data['id_carrera'] = Asignatura::find($data['id_asignatura'])->carrera->id;
        
        // No se pueden crear 2 "llamado 1" ni 2 "llamado 2"
        $copia = Mesa::where('mesas.llamado', $data['llamado'])
                -> where('mesas.id_asignatura', $data['id_asignatura'])
                ->latest('mesas.fecha')
                -> first();

        if($copia){
            $diferencia = DiasHabiles::desdeHoyHasta($copia->fecha, $data['fecha']);
            $diferencia = abs($diferencia/24); // valor absoluto

            if($diferencia>0 && $diferencia<$config['diferencia_llamados']){
                return redirect()->back()->with('error','Ya hay un llamado ' . $data['llamado'] . ' para esta asignatura');
            }
        }

        // Que los profes no sean los mismos
        if(
            $data['prof_presidente'] == $data['prof_vocal_1'] ||
            $data['prof_presidente'] == $data['prof_vocal_2'] ||
            $data['prof_vocal_1'] == $data['prof_vocal_2'] && $data['prof_vocal_1'] != '0'
        ){
            return redirect()->back()->with('error','Hay profesores repetidos');
        }
    
        Mesa::create($data);
        return \redirect()->back()->with('mensaje','Se creo la mesa');
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
        $mesa = Mesa::where('id', $mesa)->with('asignatura.carrera','profesor','vocal1','vocal2','examenes.alumno')->first();
        
        $inscribiblesCursada = Cursada::with('alumno')
            -> join('alumnos','cursadas.id_alumno','alumnos.id')
            -> whereRaw('(cursadas.aprobada=1 OR cursadas.condicion=0 OR cursadas.condicion=2 OR cursadas.condicion=3)')
            -> where('cursadas.id_asignatura',$mesa->id_asignatura)
            -> orderBy('alumnos.apellido')
            -> orderBy('alumnos.nombre')
            -> get();
            
        $inscribibles = [];

        foreach ($inscribiblesCursada as $cursada) {
            $alumno = $cursada->alumno;

            $examen = Examen::where('id_alumno', $alumno->id)
                ->where(function($query) use($mesa){
                    $query->where('nota','>=',4)
                        ->orWhere('id_mesa', $mesa->id);
                })
                ->where('id_asignatura', $mesa->id_asignatura)
                ->first();
            
            if(!$examen){
                $inscribibles[]=$alumno;
            }
        }

        return view('Admin.Mesas.edit', [
            'mesa' => $mesa,
            'profesores'=> Profesor::orderBy('apellido')->orderBy('nombre')->get(),
            'inscribibles' => $inscribibles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mesa $mesa)
    {
        //CAMIAR REQUEST ALL
        $data = $request->only(['fecha','llamado', 'prof_presidente','prof_vocal_1','prof_vocal_2']);
        
        // verificar que no sea sabado ni domingo
        if(DiasHabiles::esFinDeSemana($data['fecha'])){
            return \redirect()->back()->with('error','La fecha es fin de semana');
        }

        // verificar que no sea feriado, o similar
        if(!DiasHabiles::esDiaHabil($data['fecha'])){
            return \redirect()->back()->with('error','La fecha es un dia no habil');
        }

        if(
            $data['prof_presidente'] == $data['prof_vocal_1'] ||
            $data['prof_presidente'] == $data['prof_vocal_2'] ||
            $data['prof_vocal_1'] == $data['prof_vocal_2'] && $data['prof_vocal_1'] != '0'
        ){
            return redirect()->back()->with('error','Hay profesores repetidos');
        }

        $mesa->update($data);
        return redirect()->back()->with('mensaje','Se edito la mesa');
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
