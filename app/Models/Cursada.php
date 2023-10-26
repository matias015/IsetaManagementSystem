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

    public function condicionString(){
        switch($this->condicion){
            case 0:
                return 'Libre';
                break;
            case 1:
                return 'Regular';  
                break;
            case 2:
                return 'Promocion';  
                break;
            case 3:
                return 'Equivalencia';  
                break;
            case 4:
                return 'Desertor';
                break;
            default:
                return 'Otro';
        } 
    }

    public function aprobado(){
        if ($this->aprobada==1)
            return 'Aprobada';
        elseif($this->aprobada==2)
            return 'Reprobada';
        else
            return 'Cursando';
    }
    

}
