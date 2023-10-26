<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Egresado extends Model
{
    use HasFactory;

    protected $table = "egresadoinscripto";
    public $timestamps = false;

    protected $fillable = ['id_alumno','id_carrera','anio_inscripcion','indice_libro_matriz','anio_finalizacion'];

    public function alumno(){
        return $this -> hasOne(Alumno::class,'id','id_alumno');
    }
    public function carrera(){
        return $this -> hasOne(Carrera::class,'id','id_carrera');
    }

}
