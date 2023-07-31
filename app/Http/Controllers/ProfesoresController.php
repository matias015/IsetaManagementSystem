<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfesoresController extends Controller
{
    function mesas(){

        $profesor = Auth::guard('profesor')->user();

        $mesas = Mesa::where(function ($query) use ($profesor) {
            $query->where('prof_presidente', $profesor->id)
                ->orWhere('prof_vocal_1', $profesor->id)
                ->orWhere('prof_vocal_2', $profesor->id);
        })
        ->whereRaw('fecha > NOW()')
        ->get();
        return view('Profesores.Datos.mesas', ['mesas'=>$mesas, 'profesor'=>$profesor]);
    }
}
