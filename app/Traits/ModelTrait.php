<?php

namespace App\Traits;

trait ModelTrait {
    
    public function selectInput($name, $label, $class='flex-col py-1 px-5', $item,$options) {
        $firstItem = null;
        $inputClass = 'p-1 w-75p';
        $items = null;
        $functionForItems = 'itemsForSelect';
        
        if(isset($options['first_item'])){
            $firstItem = $this->firstItemsForSelect();
        }

        if(isset($options['items'])){
            $functionForItems = $options['items'];
        }

        $items = $this->$functionForItems();

        if(isset($options['input_class'])){
            $inputClass = $options['input_class'];
        }

        return view('Componentes.form.select', [
            'name' => $name,
            'items' => $items,
            'class' => $class,
            'label' => $label,
            'firstItem' => $firstItem,
            'inputClass' => $inputClass,
            'item' => $item
        ])->render();

    }

}