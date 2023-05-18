<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    protected $table = "asignaturas";
    use HasFactory;

    public function cursadas(){
        return $this -> hasMany(Cursada::class,'id_asignatura');
    }
    
}
