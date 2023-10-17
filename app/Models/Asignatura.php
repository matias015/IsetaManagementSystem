<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    protected $table = "asignaturas";
    use HasFactory;

    public $timestamps = false;

    protected $fillable =  ['nombre',
    'id_carrera',
    'tipo_modulo',
    'carga_horaria',
    'anio',
    'observaciones',
    'promocionable'];

    public function cursadas(){
        return $this -> hasMany(Cursada::class,'id_asignatura');
    }

    public function carrera(){
        return $this -> belongsTo(Carrera::class,'id_carrera','id');
    }

    public function correlativas(){
        return $this -> hasMany(Correlativa::class,'id_asignatura');
    }   

    
}
