<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlumnoLoginRequest;
use App\Mail\VerificacionEmail;
use App\Models\Admin;
use App\Models\Alumno;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Session\Session as SessionSession;

class AlumnoAuthController extends Controller
{
    function loginView(){
        return view('Alumnos.Auth.login');
    }

    function login(AlumnoLoginRequest $request){
        $data = $request->validated();
        $alumno = Alumno::where('correo',$data['correo'])->andWhere('password',$data['password']);
        
    }

    function registroView(){
        return view('Alumnos.Auth.registro');
    }

    public function registro(AlumnoLoginRequest $request){
        $data = $request->validated();

        // si existe el correo y tiene password a 0
        $alumno = Alumno::existeSinPassword($data['correo']);

        if(!$alumno ) return redirect()->back()->with('error','No existe ese mail o ya esta registrado');
        
        // setea password 
        $alumno -> password = bcrypt($data['password']);
        $alumno -> save();

        $token = rand(1,100);

        session(['__alumno_verificacion_token', $token]);

        Auth::login($alumno);

        Mail::to($request->user())->send(new VerificacionEmail($token));
        return redirect() -> route('token.ingreso');
    }
}
