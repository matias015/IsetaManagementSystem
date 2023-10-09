<?php

namespace App\Http\Controllers;

use App\Mail\RestablecerMail;
use App\Mail\VerificacionEmail;
use App\Models\Alumno;
use App\Models\ResetToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

use function PHPUnit\Framework\returnSelf;

class PasswordResetController extends Controller
{
    public function __construct()
    {
        $this -> middleware('guest');
    }

    function vista(){
        return view('Alumnos.Reset-password.reset');
    }

    function mail(Request $request){

        if(!Alumno::where('email',$request->email)->first()){
            return \redirect()->back()->with('error','No hay ningun alumno con este mail');
        }

        $token = rand(100000,999999);

        Session::put('__alumno_restablecer_token', $token);
        Session::put('__alumno_restablecer_mail', $request->email);

        Mail::to($request->email)->send(new RestablecerMail($token));
        
        return view('Alumnos.Reset-password.ingreso-token');
    }

    function validarToken(Request $request){
        // $tokenData = ResetToken::where('token',$request->token)->first();
        
        $token = Session::get('__alumno_restablecer_token');

        $mail = Session::get('__alumno_restablecer_mail');

        if(!$token || !$mail) return \redirect()->back()->with('error','Vaya... hemos perdido el mail o el token, intentalo de nuevo');

        if($token != $request->token) {
            return \redirect()->back()->with('error','Token incorrecto, se ha enviado un nuevo token');
        }
        
        $alumno = Alumno::where('email',$mail)->first();

        if($alumno -> password == 0) {
            return \redirect()->route('alumno.registro')->with('error','No estas registrado');
        }

        $alumno->password = bcrypt($request->password);
        $alumno->save();

        $request->session()->forget('__alumno_restablecer_token');
        $request->session()->forget('__alumno_restablecer_mail');
        // ResetToken::where('email',$request->email)->delete();
        
        return redirect()->route('alumno.login')->with('mensaje','Se ha restablecido tu contraseña');
    }
}
