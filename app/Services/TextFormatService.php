<?php

namespace App\Services;

class TextFormatService{
    static function utf8Minusculas ($texto){
        return ucfirst(mb_strtolower(utf8_encode($texto)));
    }


}