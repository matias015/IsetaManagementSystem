<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Habiles;
use App\Services\DiasHabiles;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnValue;

class AdminDiasHabilesController extends Controller
{

    function __construct()
    {
        $this -> middleware('auth:admin');
    }
    
    function index(){
        $habiles=Habiles::all();
        return view('Admin.DiasHabiles.index',\compact('habiles'));
    }

    function store(Request $request){

        if(Habiles::where('fecha',$request->input('fecha'))->first()) return \redirect()->back()->with('error','ya existe la fecha');

        Habiles::create([
            'fecha' => $request->input('fecha')
        ]);

        return \redirect()->back();
    }

    function destroy(Request $request, Habiles $habil){
        $habil->delete();
        return redirect()->back()->with('mensaje','Se elimino la fecha');
    }
}
