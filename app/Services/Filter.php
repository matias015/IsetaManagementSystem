<?php

namespace App\Services;

class Filter{

    function generate($url,$filters,$data){
        return view('Componentes.form.filters', [
            'dropdowns' => isset($data['dropdowns'])? $data['dropdowns'] : false,
            'fields' => isset($data['fields'])? $data['fields'] : false,
            'url' => $url,
            'filters' => $filters
        ])->render();
    }

    /*
    
    $filter->generate([
        'dropdowns' => [
            $carreraM->dropdown('filter_carrera_id','Carrera:', 'label-input-y-100',$filters, ['first_items' => ['Todas']])
        ],
        'fields' => [
            '
        ]
    ])

     */

}