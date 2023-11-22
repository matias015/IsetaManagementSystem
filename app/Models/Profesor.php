<?php

namespace App\Models;

use App\Services\TextFormatService;
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

    public function nombreApellido(){
        return $this->nombre.' '.$this->apellido;
    }
    
    public function apellidoNombre(){
        return $this->apellido.' '.$this->nombre;
    }

    public function dniPuntos(){
        return number_format($this->dni, 0, ',', '.');
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = TextFormatService::ucwords($value);
    }

    public function setApellidoAttribute($value)
    {
        $this->attributes['apellido'] = TextFormatService::ucwords($value);
    }

    public function setCiudadAttribute($value)
    {
        $this->attributes['ciudad'] = TextFormatService::ucfirst($value);
    }

    public function setObservacionesAttribute($value)
    {
        $this->attributes['observaciones'] = TextFormatService::ucfirst($value);
    }

    public function setCalleAttribute($value)
    {
        $this->attributes['calle'] = TextFormatService::ucfirst($value);
    }
}
