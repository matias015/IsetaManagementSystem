<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Examen extends Model
{
    protected $table = "examenes";
    protected $fillable = ['id_mesa','id_asignatura','id_alumno','nota','fecha','aprobado'];
    public $timestamps = false;
    use HasFactory;

    function mesa(){
        return $this -> belongsTo(Mesa::class,'id_mesa');
    }

    function alumno(){
        return $this -> belongsTo(Alumno::class,'id_alumno');
    }

    function asignatura(){
        return $this -> belongsTo(Asignatura::class,'id_asignatura');
    }

    function fecha(){
        if( $this-> fecha ){
           return $this->fecha;
        }
     
        $mesa = Mesa::where('id', $this->id_mesa)
           -> first();
     
        if( !$mesa ) return null;
        
        return $mesa->fecha;
     }

 

    public function tipoFinal(){
        if($this->tipo_final == 1) return "Escrito";
        else if($this->tipo_final == 2) return "Oral";
        else if($this->tipo_final == 3) return "Promocionado";
        else return "Sin especificar";
    }

    public function nota(){
        if($this->aprobado == 3) return 'Ausente';
        else if($this->nota <= 0) return 'Aun no rendido';
        else return $this->nota;
    }


}