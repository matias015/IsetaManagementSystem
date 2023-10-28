<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Correlativa extends Model
{
    use HasFactory;
    protected $table = "correlatividades";
    protected $fillable = ['id_asignatura','asignatura_correlativa'];
    public $timestamps = false;

    public function asignatura(){
        return $this->BelongsTo(Asignatura::class,'asignatura_correlativa','id');
    }

    static function debeExamenesCorrelativos($asignatura){
        $asignatura = Asignatura::with('correlativas.asignatura')
        ->where('id', $asignatura->id)
        ->first();    
     
        $sinAprobar = [];

        foreach($asignatura->correlativas as $correlativa){
           $asigCorr = $correlativa->asignatura;
     
           if($asigCorr->aproboExamen(Auth::user())) continue;
           else $sinAprobar[] = $asigCorr;
        }
     
        if(count($sinAprobar)>0) return $sinAprobar;
        else return false;
     }

}
