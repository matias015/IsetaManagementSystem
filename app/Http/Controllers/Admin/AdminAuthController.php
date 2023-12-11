<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\AdminLoginRequest;
use App\Models\Admin;
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
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('auth:admin')->only('logout');
    }

    /*
     | ------------------------------------------
     | valida las credenciales del administrador
     | ------------------------------------------
     */

    function login(AdminLoginRequest $request){
        $validateData = $request->validated();

        $usernameGiven = $validateData['username'];
        $passwordGiven = $validateData['password'];

        $admin = Admin::where('username', $usernameGiven)->first();

        if(!$admin || !Hash::check($passwordGiven, $admin->password)) {
            return redirect()->route('admin.login')->with('error','Credenciales incorrectas');
        }

        Auth::guard('admin')->login($admin);
        return redirect()->route('admin.alumnos.index');
    }

    function logout(){
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
