<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    protected $table = "examenes";
    protected $fillable = ['id_mesa','id_alumno','nota'];
    public $timestamps = false;
    use HasFactory;

    function mesa(){
        return $this -> belongsTo(Mesa::class,'id_mesa');
    }

    function alumno(){
        return $this -> belongsTo(Alumno::class,'id_alumno');
    }

    

}