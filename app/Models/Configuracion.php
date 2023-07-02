<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    use HasFactory;

    protected $table = "config";

    static function get($key,$int=false){
        $value = Configuracion::where('key',$key)->first();
        if($int) return intval($value->value);
        return $value->value;
    }
     
}
