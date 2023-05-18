<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    protected $table = "examenes";
    use HasFactory;

    function mesas(){
        return $this -> belongsTo(Mesa::class,'id_mesa');
    }

    function alumno(){
        return $this -> belongsTo(Alumno::class,'id_alumno');
    }

}
