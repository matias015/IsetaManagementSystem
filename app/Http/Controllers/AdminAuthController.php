<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth:admin')->only('logout');
    }

    function loginView(){
        return view('Admin.Auth.login');
    }

    function login(AdminLoginRequest $request){
        $data = $request->validated();
        $admin = Admin::where('username',$data['username'])->where('password',$data['password'])->first();
        if(!$admin) return redirect()->back()->with('error','incorrecto');

        Auth::guard('admin')->login($admin);
        
    }
}
