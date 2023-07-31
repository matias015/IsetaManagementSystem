<?php

namespace App\Services;

class TextFormatService{
    static function utf8Minusculas ($texto){
        return ucfirst(mb_strtolower($texto));
    }

    static function utf8UpperCamelCase ($texto){
        return ucwords(mb_strtolower($texto));
    }

}