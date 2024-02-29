<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppInfo;
use Illuminate\Http\Request;

class AdminCopiaDB extends Controller
{

    public function __construct() {
        $this->middleware('auth:admin');
    }

    function crearCopia(){
        shell_exec('C:\xampp\mysql\bin\mysqldump.exe --user=root --password= movedb > C:\copia\copia_seguridad.sql');
        return redirect()->back()->with('mensaje','Se creo la copia de seguridad');
    }
    
    function restaurarCopia(){
        shell_exec('C:\xampp\mysql\bin\mysql.exe --user=root --password= movedb < C:\copia\copia_seguridad.sql ');
        return redirect()->back()->with('mensaje','Se restauro la copia de seguridad');
    }
    
}
