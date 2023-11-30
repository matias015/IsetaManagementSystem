<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Configuracion;
use App\Models\Correlativa;
use App\Models\Cursada;
use App\Models\Examen;
use App\Models\Mesa;
use App\Models\Profesor;
use App\Services\AlumnoInscripcionService;
use App\Services\DiasHabiles;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exact;

class ExamenesCrudController extends Controller
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
        return redirect()->back();       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Mesa $mesa)
    {
        return redirect()->back(); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, AlumnoInscripcionService $inscripcionService)
    {

        if(!$request->input('id_alumno')){
            return redirect() -> back() -> with('error','No has seleccionado ningun alumno');
        }else{}

        $data = $request->only('id_alumno','id_mesa');

        $mesa = Mesa::find($data['id_mesa']);
        $alumno = Alumno::find($data['id_alumno']);
        
        $res = $inscripcionService->puedeInscribirse($mesa,$alumno);
        if(!$res['success']) return \redirect()->back()->with('error',$res['mensaje']);
      
        Examen::create([
            'id_alumno' => $data['id_alumno'],
            'id_mesa' => $mesa->id,
            'id_asignatura' => $mesa->id_asignatura,
            'nota'=> 0,
            'aprobado' => 0,
            'fecha' => now()
        ]); 

        return redirect() -> back() -> with('mensaje','anotado');
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
    public function edit(Request $request, $examen)
    {   
        $examen = Examen::with('mesa','asignatura' ,'alumno')->where('examenes.id',$examen)->first();
        if($examen->mesa){
            $examen -> borrable = DiasHabiles::desdeHoyHasta($examen->mesa->fecha) >= 24? true:false;
        }else if($examen->fecha){
            $examen -> borrable = DiasHabiles::desdeHoyHasta($examen->fecha) >= 24? true:false;
        }else{
            $examen -> borrable = false;
        }
        return view('Admin.Examenes.edit', [
            'examen' => $examen
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Examen $examen)
    {
        
        $examen->update($request->all());
        
        if($request->ausente){
            $examen->nota = 0;
            $examen->aprobado = 3;
        }else if($request->nota > 4){
            $examen->aprobado = 1;
        }else $examen->aprobado = 2;

        $examen->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Examen $examen)
    {
        $examen = Examen::with('mesa','asignatura' ,'alumno')->where('examenes.id', $examen->id)->first();
        //  aprobado->1, desaprobado->2, ausente->3
       

        // if($examen->nota > 0 || $examen->aprobado){
        //     return redirect()->back()->with('error','No se puede borrar porque el examen ya fue realizado por el alumno');
        // }

        // $borrable = false;

        // if($examen->mesa){
        //     $borrable = DiasHabiles::desdeHoyHasta($examen->mesa->fecha) >= 24? true:false;
        // }else if($examen->fecha){
        //     $borrable = DiasHabiles::desdeHoyHasta($examen->fecha) >= 24? true:false;
        // }else{
        //     $borrable = false;
        // }

        // if(!$borrable) return redirect()->back()->with('error','No se puede borrar porque faltan menos de 24 horas');

        $examen->delete();
        return redirect() -> route('admin.mesas.edit',['mesa'=>$examen->mesa->id]) -> with('mensaje', 'Se ha eliminado el examen');
    }

    function modificarNota(Request $request, Examen $examen){
        if(!$request->has('nota')) return \redirect()->back();

        if($request->input('nota') == 'a'){
            $examen->aprobado = 3;
            $examen->save();
            return \redirect()->back();
        }

        if($request->input('nota') <0 && $request->input('nota') > 10) return \redirect()->back();

        $examen->nota = $request->input('nota');
        $examen->aprobado = $request->input('nota')>=4? 1 : 2;
        $examen->save();
        return \redirect()->back();
    }
}
