<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cursada extends Model
{
    protected $table = 'cursadas';
    use HasFactory;

    protected $fillable = ['anio_cursada','aprobada','id_alumno','id_asignatura','condicion'];

    public $timestamps=false;

    public function alumno(){
        return $this -> hasOne(Alumno::class,'id','id_alumno');
    }

    public function asignatura(){
        return $this -> belongsTo(Asignatura::class,'id_asignatura','id');
    }


    

}
