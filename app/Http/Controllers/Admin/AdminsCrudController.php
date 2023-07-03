<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Configuracion;
use Illuminate\Http\Request;

class AdminsCrudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $admins = [];
         $filtro = "";
         $porPagina = Configuracion::get('filas_por_tabla',true);


        if($request->has('filtro')){
            $filtro = $request->filtro;
 
            $admins = Admin::where('username','LIKE','%'.$filtro.'%') -> paginate($porPagina);
            
        }else{
            $admins = Admin::paginate($porPagina);
        }
        return view('Admin.Admins.index',['admins'=>$admins, 'filtro'=>$filtro]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->only('username','password');
        $data['password'] = bcrypt($data['password']); 
        Admin::create($data);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->back();
    }
}
