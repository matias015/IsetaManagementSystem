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
   
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth:web')->only('logout');
    }

    function registroView(){
        return view('Alumnos.Auth.registro');
    }

    public function registro(Request $request){
        //$data = $request->validated();
        
        // si existe el correo y tiene password a 0
        $alumno = Alumno::existeSinPassword($request->email);
        
        if(!$alumno ) return redirect()->back()->with('error','No existe ese mail o ya esta registrado');

        // setea password 
        $alumno -> password = bcrypt($request->password);
        $alumno -> save();

        Auth::login($alumno);

        return redirect() -> route('token.ingreso');
    }

    function loginView(){
        return view('Alumnos.Auth.login');
    }

    function login(AlumnoLoginRequest $request){
        $data = $request->validated();

        $alumno = Alumno::where('email',$data['email'])->first();

        $passwordCoincide = Hash::check($data['password'], $alumno->password);
        
        if(!$alumno || !$passwordCoincide) return redirect()->route('alumno.login')->with('error','incorrecto');
        
        Auth::guard('web')->login($alumno);
        return redirect()->route('alumno.info');
    }

    function logout(){
        Auth::logout();
        return redirect()->route('alumno.login');
    }
}
