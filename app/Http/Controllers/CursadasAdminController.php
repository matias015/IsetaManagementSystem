<?php

namespace App\Http\Controllers;

use App\Models\Cursada;
use Illuminate\Http\Request;

class CursadasAdminController extends Controller
{
   
    function delete(Cursada $cursada){
        $cursada -> delete();
        return redirect()->back();
    }

    function edit(Request $request, $asignatura, $alumno){
        $cursada = Cursada::where('id_asignatura',$asignatura)->where('id_alumno',$alumno)->first();
        return view('Admin.Cursadas.edit',compact('cursada'));
    }

    function update(Request $request, Cursada $cursada){
        $cursada -> update($request->except('_token','_method'));
        return redirect()->back();
    }

    function create(){
        return view();
    }

    function store(Request $request){
        Cursada::create($request->all());
        return redirect() -> back();
    }
}
