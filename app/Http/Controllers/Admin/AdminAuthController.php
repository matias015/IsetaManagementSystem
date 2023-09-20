<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\AdminLoginRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{


    /*
     | ---------------------------------------------
     | Middleware de administrador, excepto el login 
     | ---------------------------------------------
     */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth:admin')->only('logout');
    }


    /*
     | -------------------------------------------------------
     | Muestra la vista para iniciar sesion como administrador 
     | -------------------------------------------------------
     */
     
    function loginView(){
        return view('Admin.Auth.login');
    }


    /*
     | ------------------------------------------
     | valida las credenciales del administrador
     | ------------------------------------------
     */

    function login(AdminLoginRequest $request){
        $data = $request->validated();

        $admin = Admin::where('username',$data['username'])->first();

        if(!$admin || !Hash::check($data['password'], $admin->password)) return redirect()->route('admin.login')->with('error','incorrecto');
       
        
        if(!$admin) return redirect()->back()->with('error','incorrecto');

        Auth::guard('admin')->login($admin);
        return redirect()->route('admin.alumnos.index');
    }

    function logout(){
        Auth::logout();
        return \redirect()->route('alumno.login');
    }
}
