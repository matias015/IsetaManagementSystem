<?php

namespace App\Models;

use App\Services\TextFormatService;
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
        'observaciones'
    ];

    public function cursadas(){
        return $this -> hasMany(Cursada::class,'id_asignatura')->where('anio_cursada', Configuracion::get('anio_ciclo_actual'));
    }

    public function carrera(){
        return $this -> belongsTo(Carrera::class,'id_carrera','id');
    }

    public function correlativas(){
        return $this -> hasMany(Correlativa::class,'id_asignatura');
    }   

    public function mesas(){
        return $this -> hasMany(Mesa::class,'id_asignatura')->whereRaw('fecha >= NOW()');
    }

    public function getAnioAttribute($value){
        return $value + 1;
    }

    function estaCursando($alumno){
        $cursada = Cursada::where('id_alumno', $alumno->id)
            -> where('id_asignatura', $this->id)
            -> where('aprobada', 3)
            -> where('condicion', 1)
            -> first();

        return $cursada;
    }
    
    function aproboExamen($alumno){
        $examen = Examen::where('id_alumno',$alumno->id)
            -> where('id_asignatura', $this->id)
            -> where('nota','>=',4)
            -> first();
     
        if($examen) return $examen;
        return null;
     }

     function aproboCursada($alumno){
        $cursada = Cursada::
            where('id_alumno', $alumno->id)
            -> where('id_asignatura',$this->id)
            ->where(function($subQuery){
                $subQuery -> where('aprobada', 1)
                -> orWhere('condicion', 0)
                -> orWhere('condicion', 2)
                -> orWhere('condicion', 3);
            })
            -> first();

        if($cursada) return $cursada;
        return null;
     }

    public function cursantes(){
        $config=Configuracion::todas();
        return Alumno::select('cursadas.anio_cursada','cursadas.condicion','cursadas.id as cursada_id','alumnos.id','alumnos.nombre','alumnos.apellido','alumnos.dni','asignaturas.id')
            -> join('cursadas','cursadas.id_alumno','alumnos.id')
            -> join('asignaturas','cursadas.id_asignatura','asignaturas.id')
            -> where('asignaturas.id', $this->id)
            // -> where('cursadas.aprobada', 3)
            -> where('anio_cursada', $config['anio_ciclo_actual'])
            -> get();
    }
    
    function tieneLaCorrelativa($id){
        $existente = Correlativa::where('id_asignatura', $this->id)
        ->where('asignatura_correlativa', $id)
        ->first();
        
        return $existente;
    }

    public function anioStr(){
        $strings = ['Primer año','Segundo año','Tercer año', 'Cuarto año', 'Quinto año', 'Sexto año'];
        return $strings[$this->anio-1];
    }

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = TextFormatService::ucwords($value);
    }

    public function setAnioAttribute($value)
    {
        $this->attributes['anio'] = $value-1;
    }

    public function setObservacionesAttribute($value)
    {
        $this->attributes['observaciones'] = TextFormatService::ucfirst($value);
    }


}

