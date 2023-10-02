<?php

namespace App\Services;

class TextFormatService{
    static function ucfirst ($texto){
        return ucfirst(mb_strtolower($texto));
    }

    static function ucwords ($texto){
        return ucwords(mb_strtolower($texto));
    }

}