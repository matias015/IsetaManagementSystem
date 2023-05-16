<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlumnoLoginRequest;
use Illuminate\Http\Request;

class AlumnoAuthController extends Controller
{
    function loginView(){
        return view('Alumnos.Auth.login');
    }

    function login(AlumnoLoginRequest $request){
        
    }
}
