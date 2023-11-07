<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asignatura;
use App\Models\Correlativa;
use Illuminate\Http\Request;

class AdminCorrelativasController extends Controller
{

    function __construct()
    {
        $this -> middleware('auth:admin');
    }
    
    function agregar(Request $request, Asignatura $asignatura){

        if($asignatura->anio == 1) return redirect()->back()->with('error', 'No puedes añadir correlativas en asignaturas del primer año');

        if(!$asignatura->anio > Asignatura::find($request->id_asignatura)->anio-1){
            return \redirect()->back()->with('error','El año de la correlativa debe ser menor al de la asignatura');
        } 

        if($asignatura->existe($request->id_asignatura))  return \redirect()->back()->with('error','Esta asignatura ya tiene esta correlativa');

        Correlativa::create([
            'id_asignatura' => $asignatura->id,
            'asignatura_correlativa' => $request->id_asignatura
        ]);

        return redirect()->back()->with('mensaje','Se agrego la correlativa');
    }

    function eliminar(Request $request, Asignatura $asignatura){
        $correlativa = Correlativa::where('id_asignatura', $asignatura->id)
            ->where('asignatura_correlativa', $request->asignatura_correlativa)
            ->first();
        
        $correlativa->delete();
        return redirect()->back()->with('mensaje','Se elimino la correlativa');
    }
}
