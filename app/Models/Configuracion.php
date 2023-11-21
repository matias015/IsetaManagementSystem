<?php

namespace App\Models;

use App\Services\DiasHabiles;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Configuracion extends Model
{
    use HasFactory;

    protected $table = "config";
    public $timestamps = false;

    static function get($key,$int=false){
        $value = Configuracion::where('key',$key)->first();
        if($int) return intval($value->value);
        return $value->value;
    }

    static function todas(){
        if(session('config')){
            return session('config');
        }else{
            $config = Configuracion::all()->pluck('value','key')->toArray();
            session(['config',$config]);
            return $config;
        }
        
    }


    static function puedeDesinscribirCursada(){
        if(DiasHabiles::desdeHoyHasta(Configuracion::get('fecha_limite_desrematriculacion')) <= 0){
            return false;
        }
        return true;
    }
    
     
}
