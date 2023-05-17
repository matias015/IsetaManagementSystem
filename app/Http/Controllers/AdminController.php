<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function __construct()
    {
        $this -> middleware('auth:admin');
    }

    function alumnos(){
        return view('Admin.alumnos', ['alumnos'=>Alumno::all()]);
    }
}
