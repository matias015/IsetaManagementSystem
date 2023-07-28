<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    use HasFactory;

    protected $table = "mesas";

    public $timestamps = false;
    protected $fillable = ['id_carrera','id_asignatura','prof_presidente','prof_vocal_1','prof_vocal_2','llamado','fecha'];

    // protected $casts = [
    //     'fecha' => 'datetime',
    // ];

    public function materia(){
        return $this -> hasOne(Asignatura::class,'id','id_asignatura');
    }

    public function profesor(){
        return $this -> hasOne(Profesor::class,'id','prof_presidente');
    }
    
    public function vocal1(){
        return $this -> hasOne(Profesor::class,'id','prof_vocal_1');
    }

    

    public function vocal2(){
        return $this -> hasOne(Profesor::class,'id','prof_vocal_2');
    }

}
