<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Examen extends Model
{
    protected $table = "examenes";
    protected $fillable = ['id_mesa','id_asignatura','id_alumno','nota'];
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

    static function delAlumnoMasAltas(){
        $id = Auth::id();

        $examenes = Examen::select('asignaturas.id','asignaturas.nombre','nota','id_asignatura','fecha')
            -> join('asignaturas', 'asignaturas.id','examenes.id_asignatura')
            -> where('asignaturas.id_carrera', Carrera::getDefault())
            -> where('id_alumno', $id)
            -> orderBy('asignaturas.id')
            -> get();
        

        $notas_mas_altas = [];

        foreach ($examenes as $examen) {
            $id_asignatura = $examen->id_asignatura;
            $nota = $examen->nota;
        
            // Comprobar si ya tenemos un objeto registrado para esta asignatura
            if (isset($notas_mas_altas[$id_asignatura])) {
                // Si ya hay un objeto registrado, comprobar si la nota actual es más alta
                if ($nota > $notas_mas_altas[$id_asignatura]->nota) {
                    // Si es más alta, actualizar el objeto en el arreglo
                    $notas_mas_altas[$id_asignatura] = $examen;
                }
            } else {
                // Si no hay un objeto registrado para esta asignatura, simplemente agregarlo
                $notas_mas_altas[$id_asignatura] = $examen;
            }
        }
        
        // Ahora, $notas_mas_altas contiene la nota más alta para cada asignatura
        return $notas_mas_altas;
    }

}