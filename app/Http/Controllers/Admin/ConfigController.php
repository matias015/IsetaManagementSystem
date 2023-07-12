<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\AdminLoginRequest;
use App\Models\Admin;
use App\Models\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ConfigController extends Controller
{
    public function index(){
        $configuracion=Configuracion::all()-> pluck('value','key')-> toArray();
        return view('Admin/config',compact('configuracion'));
    }

    public function setear(Request $request){
        
        
        foreach($request->except('_token') as $key => $value){
            Configuracion::where('key', $key)
            ->update(['value'=>$value]);
        }
        
        return redirect()->back();
    }
}
