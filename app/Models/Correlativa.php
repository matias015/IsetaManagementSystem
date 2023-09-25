<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Correlativa extends Model
{
    use HasFactory;
    protected $table = "correlatividades";
    protected $fillable = ['id_asignatura','asignatura_correlativa'];
    public $timestamps = false;

    public function asignatura(){
        return $this->BelongsTo(Asignatura::class,'asignatura_correlativa','id');
    }
}
