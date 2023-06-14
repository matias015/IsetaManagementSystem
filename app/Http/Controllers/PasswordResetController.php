<?php

namespace App\Http\Controllers;

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
        $token = rand(1,100);

        $existe = ResetToken::where('email', $request->email)->first();
        if($existe) ResetToken::where('email', $request->email)->delete();

        ResetToken::create([
            'email' => $request->email,
            'token' => $token
        ]);

        Mail::to($request->email)->send(new VerificacionEmail($token));
        
        return view('Alumnos.Reset-password.ingreso-token');
    }

    function validarToken(Request $request){
        $tokenData = ResetToken::where('token',$request->token)->first();
        
        if($tokenData) {
            $alumno = Alumno::where('email',$tokenData->email)->first();
            $alumno->password = bcrypt($request->password);
            $alumno->save();
            
            ResetToken::where('email',$request->email)->delete();
        }
        return redirect()->route('alumno.login');
    }
}
