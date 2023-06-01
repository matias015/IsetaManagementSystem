<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Carrera extends Model
{
    use HasFactory;
    protected $table = "carrera";
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'resolucion',
        'anio_apertura',
        'anio_fin',
        'observaciones',
    ];

    public function asignaturas(){
        return $this -> hasMany(Asignatura::class, 'id_carrera');
    }

    static function getDefault(){
        $carrera = CarreraDefault::select('id_carrera')
            -> where('id_alumno',Auth::id())
            -> first();

            if($carrera) return $carrera->id_carrera;

            $carrera=Carrera::select('carrera.id', 'carrera.nombre')
            -> join('asignaturas', 'asignaturas.id_carrera', 'carrera.id')
            -> join('cursada', 'cursada.id_asignatura', 'asignaturas.id')
            -> where('cursada.id_alumno', Auth::id()) 
            -> groupBy('carrera.id', 'carrera.nombre')
            -> first();

            if(!$carrera) return null;
            return $carrera->id;
            
            

            
    }

}
