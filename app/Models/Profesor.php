<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Profesor extends Authenticatable
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
    
    static function existeSinPassword($data){
        return Profesor::where('email', $data['email'])
            -> where('password','0')
            -> where('dni',$data['dni'])
            -> first();
    }
    public function verificar(){
        $this->verificado = 1;
        $this->save();
    }
}
