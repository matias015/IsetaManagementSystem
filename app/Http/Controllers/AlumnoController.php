<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Examen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AlumnoController extends Controller
{

    public function __construct()
    {
        $this -> middleware('auth:web');
    }

    function info(){
        return view('Alumnos.Datos.informacion', ['alumno'=>Auth::user()]);
    }

    function cursadas(){
        $user = Auth::user();

        $cursadas = $user->cursadas()->with('materia')->get();

        $examenesAprobados = DB::table('examenes')
            -> join('mesa','examenes.id_mesa','mesa.id')
            -> select('mesa.id_asignatura')
            -> where('examenes.nota','>=',4)
            -> where('examenes.id_alumno',Auth::id())
            -> get()
            -> pluck('id_asignatura')
            -> toArray();
    
        return view('Alumnos.Datos.cursadas', ['cursadas'=>$cursadas, 'examenesAprobados'=>$examenesAprobados]);
    
    }
}
