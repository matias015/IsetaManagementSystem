<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    protected $table = "asignaturas";
    use HasFactory;

    public $timestamps = false;

    protected $fillable =  ['nombre',
    'id_carrera',
    'tipo_modulo',
    'carga_horaria',
    'anio',
    'observaciones',
    'promocionable'];

    public function cursadas(){
        return $this -> hasMany(Cursada::class,'id_asignatura')->where('anio_cursada', Configuracion::get('anio_remat'));
    }

    public function carrera(){
        return $this -> belongsTo(Carrera::class,'id_carrera','id');
    }

    public function correlativas(){
        return $this -> hasMany(Correlativa::class,'id_asignatura');
    }   

    public function cursantes(){
        $config=Configuracion::todas();
        return Alumno::select('cursadas.anio_cursada','cursadas.condicion','cursadas.id as cursada_id','alumnos.id','alumnos.nombre','alumnos.apellido','alumnos.dni','asignaturas.id')
            -> join('cursadas','cursadas.id_alumno','alumnos.id')
            -> join('asignaturas','cursadas.id_asignatura','asignaturas.id')
            -> where('asignaturas.id', $this->id)
            // -> where('cursadas.aprobada', 3)
            -> where('anio_cursada', $config['anio_remat'])
            -> get();
    }
    
}
