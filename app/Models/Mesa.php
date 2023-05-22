<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    use HasFactory;

    protected $table = "mesa";

    public function materia(){
        return $this -> hasOne(Asignatura::class,'id_asignatura');
    }
}
