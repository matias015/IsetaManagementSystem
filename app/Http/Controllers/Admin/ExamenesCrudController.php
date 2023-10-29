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
         $examenes = [];
         $filtro = "";
         $campo = "";
         $porPagina = Configuracion::get('filas_por_tabla',true);

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
    public function create(Request $request, Mesa $mesa)
    {
        return view('Admin.Examenes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->only('id_alumno','id_mesa');
        $mesa = Mesa::find($data['id_mesa']);
     
        $asignatura = $mesa->asignatura;
        $alumno = Alumno::find($data['id_alumno']);

        if($asignatura->aproboExamen($alumno)){
            return redirect() -> back() -> with('error','El alumno ya aprobo esta asignatura.');
        }

        if(!$asignatura->aproboCursada($alumno)){
            return redirect() -> back() -> with('error','El alumno no aprobo la cursada.');
        };

        // Que no este ya anotado
        $yaAnotado = Examen::select('id')
            -> where('id_mesa', $mesa->id)
            -> where('id_alumno', $data['id_alumno'])
            -> first();

        if($yaAnotado) {
            return redirect() -> back() -> with('error','ya esta anotado');
        }

        // que no deba equivalencias
        foreach($asignatura->correlativas as $correlativa){

            $correlativas = Correlativa::debeExamenesCorrelativos($asignatura,$alumno);
            // \dd($correlativas);
            if($correlativas){
                $mensajes = [];
                foreach ($correlativas as $correlativa) {
                    $mensajes[]='Debe correlativa: '.$correlativa->nombre;
                }
                return redirect() -> back() -> with('error',$mensajes);
            }
        };

        // $posibles = Alumno::inscribibles($data['id_alumno']);

        $noPuede = true;
        $finBusqueda = false;
        
        // la materia que selecciono esta en las que puede inscribirse
        // y no caduco la fecha de inscripcion


        // foreach($asignatura->mesas as $mesaMateria){
            
        //     if($mesaMateria->id == $mesa->id){
        //         if(DiasHabiles::desdeHoyHasta($mesaMateria->fecha) >= 48) $noPuede = false;
        //         else break;
        //         $finBusqueda=true;
        //     }

        // }
        

        // if(1) {
        //     return redirect() -> back() -> with('error','no puede anotarse a esta mesa');
        // }
        
        

        //////////////////
      
        Examen::create([
            'id_alumno' => $data['id_alumno'],
            'id_mesa' => $mesa->id,
            'id_asignatura' => $mesa->id_asignatura,
            'nota'=> 0,
            'aprobado' => 0
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
       

        if($examen->nota > 0 || $examen->aprobado){
            return redirect()->back()->with('error','No se puede borrar porque el examen ya fue realizado por el alumno');
        }

        $borrable = false;

        if($examen->mesa){
            $borrable = DiasHabiles::desdeHoyHasta($examen->mesa->fecha) >= 24? true:false;
        }else if($examen->fecha){
            $borrable = DiasHabiles::desdeHoyHasta($examen->fecha) >= 24? true:false;
        }else{
            $borrable = false;
        }

        if(!$borrable) return redirect()->back()->with('error','No se puede borrar porque faltan menos de 24 horas');

        $examen->delete();
        return redirect() -> route('admin.mesas.edit',['mesa'=>$examen->mesa->id]) -> with('mensaje', 'Se ha eliminado el examen');
    }
}
