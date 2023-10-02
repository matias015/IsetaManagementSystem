<?php

namespace App\Http\Controllers;

use App\Mail\RestablecerMail;
use App\Mail\VerificacionEmail;
use App\Models\Alumno;
use App\Models\ResetToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    function vista(){
        return view('Alumnos.Reset-password.reset');
    }

    function mail(Request $request){
        $token = rand(100000,999999);

        $existe = ResetToken::where('email', $request->email)->first();
        if($existe) ResetToken::where('email', $request->email)->delete();

        ResetToken::create([
            'email' => $request->email,
            'token' => $token
        ]);

        Mail::to($request->email)->send(new RestablecerMail($token));
        
        return view('Alumnos.Reset-password.ingreso-token');
    }

    function validarToken(Request $request){
        $tokenData = ResetToken::where('token',$request->token)->first();
        
        if(true) {
            $alumno = Alumno::where('email',$tokenData->email)->first();
            $alumno->password = bcrypt($request->password);
            $alumno->save();
            
            ResetToken::where('email',$request->email)->delete();
        }
        return redirect()->route('alumno.login');
    }
}
