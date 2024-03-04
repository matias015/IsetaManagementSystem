<?php

namespace App\Traits;

trait ModelTrait {
    
    public function dropdown($name, $label=null, $class='label-select-y', $item=null,$options=[]) {
        $firstItems = [];
        $items = null;
        $filter = null;
      
        if(isset($options['filter']))
            $filter = $options['filter'];

        if(isset($options['first_items']))
            $firstItems = $options['first_items'];

        if($filter)
            $items = $this->elementsForDropdown($filter);
        else    
            $items = $this->all();

        return view('Componentes.form.select', [
            'name' => $name,
            'items' => $items,
            'class' => $class,
            'label' => $label,
            'firstItems' => $firstItems,
            'options' => $options,
            'item' => $item
        ])->render();

    }

}