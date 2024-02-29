<?php

namespace App\Traits;

use function Termwind\render;

trait ModelTrait {
    
    public function selectInput($args) {
        $items = self::all();

        return view('Componentes.form.select', [
            'items' => $args['items'],
            'name' => $args['name'],
            'class' => $args['class'],
            'first' => $args['first']
        ])->render();

    }

}