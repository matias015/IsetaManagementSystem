<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;
    protected $table = 'mensajes';

    protected $fillable = ['mensaje','id_alumno','respuesta'];

    function alumno(){
        return $this->belongsTo(Alumno::class,'id_alumno');
    }
}
