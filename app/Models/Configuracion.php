<?php

namespace App\Models;

use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    
     
}
