<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrearMesaRequest;
use App\Http\Requests\EditarMesaRequest;
use App\Models\Asignatura;
use App\Models\Carrera;
use App\Models\Configuracion;
use App\Models\Cursada;
use App\Models\Examen;
use App\Models\Mesa;
use App\Models\Profesor;
use App\Repositories\MesaRepository;
use App\Services\DiasHabiles;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MesasCrudController extends Controller
{
    public $mesaRepository;

    function __construct(MesaRepository $mesaRepository)
    {
        $this->mesaRepository = $mesaRepository;
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

        $mesas = $this->mesaRepository->conFiltros($filtro,$campo,$orden);

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

        // la fecha de la nueva mesa a crear.
        $fecha = Carbon::parse($data['fecha']);

        $fechaInicio = $fecha->copy()->subDays($config['diferencia_llamados']); // Restar 30 días
        $fechaFin = $fecha->copy()->addDays($config['diferencia_llamados']); // Sumar 30 días
        
        // buscar mesa entre $fecha-30 dias y $fecha+30 dias, es decir un periodo de 30 dias desde ambos lados
        $registro = Mesa::with('asignatura')
            -> whereBetween('fecha', [$fechaInicio, $fechaFin])
            -> where('llamado',$data['llamado'])                // que sea el mismo llamado
            -> where('id_asignatura',$data['id_asignatura'])    // de la misma asignatura
            -> first();
        
        // si se encontro avisa que ya existe
        if($registro){  
              
            $fechaMesa = Carbon::parse($registro->fecha);
            return redirect()->back()->with('error','Ya hay un llamado '.$data['llamado'].' para el dia '.$fechaMesa->format('d/m'));
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
        
        $inscribibles = $this->mesaRepository->inscribibles($mesa);

        return view('Admin.Mesas.edit', [
            'mesa' => $mesa,
            'profesores'=> Profesor::orderBy('apellido')->orderBy('nombre')->get(),
            'inscribibles' => $inscribibles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditarMesaRequest $request, Mesa $mesa)
    {
        //CAMIAR REQUEST ALL
        $data = $request->validated();
        
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
        $this->mesaRepository->delete($mesa);
        return redirect() -> route('admin.mesas.index') -> with('mensaje', 'Se ha eliminado la mesa');
    }
}
