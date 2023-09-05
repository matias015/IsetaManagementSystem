<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asignatura;
use App\Models\Correlativa;
use Illuminate\Http\Request;

class AdminCorrelativasController extends Controller
{
    function agregar(Request $request, Asignatura $asignatura){

        if($asignatura->anio == 0) return \redirect()->back()->with('error', 'No puedes añadir correlativas en asignaturas del primer año');

        Correlativa::create([
            'id_asignatura' => $asignatura->id,
            'asignatura_correlativa' => $request->asignatura_correlativa
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
