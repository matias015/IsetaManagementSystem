<?php

namespace App\Http\Controllers;

use App\Mail\VerificacionEmail;
use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class MailVerifController extends Controller
{

    function enviarMail(){
        $token = rand(1,100);
        Session::put('__alumno_verificacion_token', $token);
        Mail::to(Auth::user())->send(new VerificacionEmail($token));
        return redirect()->back()->with('mensaje','Se ha enviado el correo');
    }

    function ingresarTokenView(){
        return view('Alumnos.Mail.ingresoToken');
    }

    function verificarToken(Request $request){
        $alumno = Alumno::find(Auth::id());
        $token = Session::get('__alumno_verificacion_token');

        if($token && $token == $request->token){
            $alumno -> verificar();
            $request->session()->forget('__alumno_verificacion_token');
            return redirect()->route('alumno.login')->with('mensaje','estas verificado');
        }
        
        return redirect()->route('alumno.registro')->with('error','token incorrecto o no valido');
    }
}
