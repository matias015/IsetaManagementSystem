<?php

namespace App\Models;

use App\Services\TextFormatService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Carrera extends Model
{
    use HasFactory;
    protected $table = "carreras";
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'resolucion',
        'anio_apertura',
        'anio_fin',
        'observaciones',
        'vigente'
    ];

    public function asignaturas(){
        return $this -> hasMany(Asignatura::class, 'id_carrera');
    }

    public function primeraAsignatura(){
        return Asignatura::where('id_carrera', $this->id)->orderBy('anio')->first();
    }

    static function getDefault($alumno_id=null){
        if($alumno_id) $alumno = Alumno::find($alumno_id);
        else $alumno = Auth::user();

        $carrera = CarreraDefault::select('id_carrera')
            -> where('id_alumno',$alumno->id)
            -> first();

            if($carrera) return Carrera::find($carrera->id_carrera);

            // ANTES
            // $carrera=Carrera::select('carreras.id', 'carreras.nombre')
            // -> join('asignaturas', 'asignaturas.id_carrera', 'carreras.id')
            // -> join('cursadas', 'cursadas.id_asignatura', 'asignaturas.id')
            // -> where('cursadas.id_alumno', $alumno->id) 
            // -> groupBy('carreras.id', 'carreras.nombre')
            // -> first();

            $carrera = Egresado::select('carreras.id', 'carreras.nombre')
                -> join('carreras','egresadoinscripto.id_carrera','carreras.id')
                -> where('egresadoinscripto.id_alumno',$alumno->id)
                -> first();

            if(!$carrera) return null;
            return $carrera;
    }



    static function vigentes(){
        return Carrera::where('vigente',1)->get();
    }

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = TextFormatService::ucwords($value);
    }

    public function setObservacionesAttribute($value)
    {
        $this->attributes['observaciones'] = TextFormatService::ucfirst($value);
    }


}
