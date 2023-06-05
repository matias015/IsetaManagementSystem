<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    use HasFactory;

    protected $table = "mesa";

    public $timestamps = false;
    protected $fillable = ['id_asignatura','prof_presidente','prof_vocal_1','prof_vocal_2','llamado','fecha'];

    public function materia(){
        return $this -> hasOne(Asignatura::class,'id','id_asignatura');
    }
}
