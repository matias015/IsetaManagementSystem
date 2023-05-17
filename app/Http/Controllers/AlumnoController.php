<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlumnoController extends Controller
{

    public function __construct()
    {
        $this -> middleware('auth:web');
    }

    function info(){
        return view('Alumnos.Datos.informacion', ['alumno'=>Auth::user()]);
    }
}
