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


    static function delAlumnoMasAltas($filtro,$campo,$orden){
        $id = Auth::id();
        $examenes = null;

        $query = Examen::select('examenes.id_mesa','examenes.aprobado','asignaturas.id','asignaturas.anio','asignaturas.nombre','nota','id_asignatura','fecha')
            -> join('asignaturas', 'asignaturas.id','examenes.id_asignatura')
            -> where('asignaturas.id_carrera', Carrera::getDefault()->id)
            -> where('id_alumno', $id);
            
            if($filtro){
                $query =  $query -> where('asignaturas.nombre','LIKE','%'.$filtro.'%');
            }
    
            if($campo == "aprobadas"){
                $query = $query -> where('nota', '>=',4);
            }
            else if($campo == "desaprobadas"){
                $query =  $query -> where('nota','<', 4);
            }
    
    
            if($orden == 'anio'){
                $query->orderBy('asignaturas.anio');
            }
            else if($orden == 'asignatura'){
                $query->orderBy('asignaturas.nombre');
            }            
            else if($orden == 'fecha'){
                $query->orderBy('examenes.fecha');
            }
            else if($orden == 'anio_desc'){
                $query->orderBy('asignaturas.anio','desc');
            }            
            else if($orden == 'fecha_desc'){
                $query->orderBy('examenes.fecha','desc');
            }
            
            $examenes = $query->get();
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