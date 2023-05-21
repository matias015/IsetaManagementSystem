<?php

use App\Http\Requests\AlumnoLoginRequest;
use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * 
 * Autenticacion (login, registro, etc) de los alumnos
 * Utilizan el guard: alumno
 * 
 */

class AlumnoAuthController extends Controller
{
   
    /**
     * Debes ser guest para acceder a las rutas
     * excepto para cerrar sesion
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth:web')->only('logout');
    }

    /**
     * muestra la ruta de registro
     */
    function registroView(){
        return view('Alumnos.Auth.registro');
    }

    /**
     * valida los datos de registro y actualiza su contraseña
     */
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

    /**
     * muestra vista de login
     */
    function loginView(){
        return view('Alumnos.Auth.login');
    }

    /**
     * valida datos y loguea al alumno
     */
    function login(AlumnoLoginRequest $request){
        $data = $request->validated();

        $alumno = Alumno::where('email',$data['email'])->first();

        if(!$alumno || !Hash::check($data['password'], $alumno->password)) return redirect()->route('alumno.login')->with('error','incorrecto');
        
        Auth::login($alumno);
        return redirect()->route('alumno.info');
    }

    /**
     * cierra sesion del alumno
     */
    function logout(){
        Auth::logout();
        return redirect()->route('alumno.login');
    }
}
