<?php
namespace App\Http\Controllers;

use App\Http\Requests\AlumnoLoginRequest;
use App\Http\Requests\AlumnoRegistroRequest;
use App\Http\Requests\ModificarPasswordRequest;
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
        $this->middleware('guest')->except('logout','cambiarPassword');
        $this->middleware('auth:web')->only(['logout','cambiarPassword']);
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
    public function registro(AlumnoRegistroRequest $request){
        $data = $request->validated();
        
        // si existe el correo y tiene password a 0
        $alumno = Alumno::existeSinPassword($data);
        
        if(!$alumno ) return redirect()->back()->with('error','mail y dni no coinciden o ya esta registrado');

        // setea password 
        $alumno -> password = bcrypt($data['password']);
        $alumno -> save();

        Auth::login($alumno);

        return redirect() -> route('token.enviar.mail');
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

        if(!$alumno || !Hash::check($data['password'], $alumno->password)) return redirect()->route('alumno.login')->with('error','Datos de usuario incorrectos');
        
        Auth::login($alumno);
        return redirect()->route('alumno.inscripciones');
    }

    /**
     * cierra sesion del alumno
     */
    function logout(){
        Auth::logout();
        return redirect()->route('alumno.login');
    }



    function cambiarPassword(ModificarPasswordRequest $request){
        $user = Auth::user();
        if(!Hash::check($request->oldPassword, $user->password)){
            return redirect()->back()->with('error','Las contraseña actual es incorrecta');
        }

        if($request->newPassword != $request->newPassword_confirmation){
            return redirect()->back()->with('error','Las contraseñas no coinciden');
        }
        
        $user->password = bcrypt($request->newPassword);
        $user->save();
        
        return redirect()->back()->with('mensaje','Se ha restablecido la contraseña');
    }
}
