<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrearMesaRequest;
use App\Http\Requests\EditarMesaRequest;
use App\Models\Asignatura;
use App\Models\Carrera;
use App\Models\Configuracion;
use App\Models\Mesa;
use App\Models\Profesor;
use App\Repositories\MesaRepository;
use App\Services\Admin\MesasCheckerService;
use App\Services\DiasHabiles;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MesasCrudController extends Controller
{
    public $mesaRepository;
    public $mesasService;

    function __construct(MesaRepository $mesaRepository, MesasCheckerService $mesasService)
    {
        $this->mesaRepository = $mesaRepository;
        $this->mesasService = $mesasService;
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
        // \dd($mesas);
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

        $esDiaValido = $this->mesasService->esDiaHabil($data['fecha']);

        if(!$esDiaValido['success']){
            return redirect()->back()->with('error', $esDiaValido['mensaje'])->withInput();
        } 

        // se añade el id de la carrera al registro de mesa, ya que no viene en el formulario
        // no deberia ser necesario pero la base de datos anterior hacia uso de esta duplicidad
        $data['id_carrera'] = Asignatura::find($data['id_asignatura'])->carrera->id;
        
        $llamadoYaExiste = $this->mesasService->llamadoYaExiste($data);
        
        if($llamadoYaExiste['success']){
            return redirect()->back()->with('error',$llamadoYaExiste['mensaje'])->withInput();
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
