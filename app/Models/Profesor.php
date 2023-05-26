<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    use HasFactory;

    protected $table = "profesores";
    public $timestamps = false;

    protected $fillable = [
        'dni',
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'ciudad',
        'calle',
        'casa_numero' ,
        'dpto' ,
        'piso' ,
        'estado_civil' ,
        'email',
        'formacion_academica' ,
        'titulo',
        'observaciones',
        'telefono1',
        'telefono2' ,
        'telefono3',
        'codigo_postal',
        'password'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'datetime',
    ];
}
