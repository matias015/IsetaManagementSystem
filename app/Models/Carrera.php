<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Carrera extends Model
{
    use HasFactory;
    protected $table = "carrera";

    static function getDefault(){
        return CarreraDefault::select('id_carrera')
            -> where('id_alumno',Auth::id())
            -> first();
        
    }

}
