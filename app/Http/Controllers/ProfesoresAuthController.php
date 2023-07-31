<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlumnoRegistroRequest;
use App\Http\Requests\ProfesorLoginRequest;
use App\Http\Requests\ProfesorRegistroRequest;
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfesoresAuthController extends Controller
{
        /**
     * Debes ser guest para acceder a las rutas
     * excepto para cerrar sesion
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout','cambiarPassword');
        $this->middleware('auth:profesor')->only(['logout','cambiarPassword']);
    }

    /**
     * muestra la ruta de registro
     */
    function registroView(){
        return view('Profesores.Auth.registro');
    }

    /**
     * valida los datos de registro y actualiza su contraseña
     */
    public function registro(ProfesorRegistroRequest $request){
        $data = $request->validated();
        
        // si existe el correo y tiene password a 0
        $profe = Profesor::existeSinPassword($data);


        
        if(!$profe ) return redirect()->back()->with('error','mail y dni no coinciden o ya esta registrado');

        // setea password 
        $profe -> password = bcrypt($data['password']);
        $profe -> save();

        Auth::guard('profesor')->login($profe);

        return redirect() -> route('token.enviar.mail.profe');
    }

    /**
     * muestra vista de login
     */
    function loginView(){
        return view('Profesores.Auth.login');
    }

    /**
     * valida datos y loguea al alumno
     */
    function login(ProfesorLoginRequest $request){
        $data = $request->validated();

        $profe = Profesor::where('email',$data['email'])->first();

        if(!$profe || !Hash::check($data['password'], $profe->password)) return redirect()->route('profesor.login')->with('error','Datos de usuario incorrectos');
        
        Auth::guard('profesor')->login($profe);
        return redirect()->route('profesor.mesas');
    }

    /**
     * cierra sesion del alumno
     */
    function logout(){
        Auth::guard('profesor')->logout();
        return redirect()->route('profesor.login');
    }



    function cambiarPassword(ModificarPasswordRequest $request){
        $user = Auth::user();
        if(!Hash::check($request->oldPassword, $user->password)){
            dd('incor');
            return redirect()->back()->with('error','la contraseña no coincide');
        }
        
        $user->password = bcrypt($request->newPassword);
        $user->save();
        
        return redirect()->back()->with('mensaje','Se ha restablecido la contraseña');
    }

}
