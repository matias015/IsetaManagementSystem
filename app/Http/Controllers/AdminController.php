<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * 
 * Funciones de administradores
 * 
 */

class AdminController extends Controller
{

    /**
     * todas rutas estan protegidas por el mw admin
     */
    function __construct()
    {
        $this -> middleware('auth:admin');
    }

    /**
     * ver todos los alumnos
     */
    function alumnos(){
        return view('Admin.alumnos', ['alumnos'=>Alumno::all()]);
    }
}
