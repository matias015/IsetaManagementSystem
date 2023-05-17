<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MailVerifController extends Controller
{
    function ingresarTokenView(){
        return view('Alumnos.Mail.ingresoToken');
    }

    function verificarToken(Request $request){
        $alumno = Alumno::find(Auth::id());
        $token = session('__alumno_verificacion_token', false);

        if($token && $alumno->token_verificacion == $request->token){
            $alumno -> verificar();
            $request->session()->forget('__alumno_verificacion_token');
            return redirect()->route('alumno.login');
        }
        
        return redirect()->route('alumno.registro')->with('error','token incorrecto o no valido');
    }
}
