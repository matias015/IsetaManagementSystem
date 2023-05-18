<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cursada extends Model
{
    protected $table = 'cursada';
    use HasFactory;

    public function cursadas(){
        return $this -> belongsTo(Alumno::class,'id_alumno');
    }

    public function materia(){
        return $this -> belongsTo(Asignatura::class,'id_asignatura');
    }


    

}
