<?php

namespace App\Services;

class FilterGenerator{
    function generate($url, $filters, $fields){

        return view('Componentes.filters', [
            'url' => $url,
            'order' => isset($fields['order'])?$fields['order']:null,
            'show' => isset($fields['show'])?$fields['show']:null,
            'searchField' => isset($fields['searchField'])?$fields['searchField']:null,
            'filters' => $filters
        ])->render();
    }

}