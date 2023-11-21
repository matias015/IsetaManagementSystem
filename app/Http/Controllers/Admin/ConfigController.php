<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\EditarConfigRequest;
use App\Models\Admin;
use App\Models\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ConfigController extends Controller
{
        function __construct()
    {
        $this -> middleware('auth:admin');
    }
    public function index(){
        $configuracion=Configuracion::all()-> pluck('value','key')-> toArray();
        return view('Admin/config',compact('configuracion'));
    }

    public function setear(EditarConfigRequest $request){
        $data = $request->validated();
      
        if(!$request->has('alumno_puede_anotarse_mesa')){
            $data['alumno_puede_anotarse_mesa'] = 0;
        }
        if(!$request->has('alumno_puede_bajarse_mesa')){
            $data['alumno_puede_bajarse_mesa'] = 0;
        } 
        if(!$request->has('alumno_puede_anotarse_cursada')){
            $data['alumno_puede_anotarse_cursada'] = 0;
        }
        if(!$request->has('alumno_puede_bajarse_cursada')){
            $data['alumno_puede_bajarse_cursada'] = 0;
        }
        if(!$request->has('alumno_puede_anotarse_libre')){
            $data['alumno_puede_anotarse_libre'] = 0;
        }
        if(!$request->has('modo_seguro')){
            $data['modo_seguro'] = 0;
        }
        

        // dd($request->except('_token'));
        foreach($data as $key => $value){
            if(!$value) $value = '';
            Configuracion::where('key', $key)
            ->update(['value'=>$value]);
        }
        
        return redirect()->back();
    }

    public function setOnly(Request $request){
            $key = key($request->except('_token'));


            Configuracion::where('key', $key)
            ->update(['value'=>$request->input($key)]);

            // key($request->except('_token'));
        
        return redirect()->back();
    }
}
