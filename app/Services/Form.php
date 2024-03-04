<?php 

namespace App\Services;

class Form{

    function select($name,$label,$class,$item,$optionsE,$options=[]){
        if(!isset($options['inputclass'])){
            $options['inputclass'] = 'p-1';
        }

        return view('Componentes.form.generic-select', [
            'type' => 'text',
            'name' => $name,
            'item' => $item,
            'optionsE' => $optionsE,
            'class' => $class,
            'label' => $label,
            'options' => $options
        ])->render();
    }

    function text($name, $label, $class, $item=null, $options=[]){

        if(!isset($options['inputclass'])){
            $options['inputclass'] = 'p-1';
        }

        return view('Componentes.form.text-input', [
            'type' => 'text',
            'name' => $name,
            'item' => $item,
            'class' => $class,
            'label' => $label,
            'options' => $options
        ])->render();
    }    

    function date($name, $label, $class, $item=null, $options=[]){

        if(!isset($options['inputclass'])){
            $options['inputclass'] = 'p-1';
        }

        return view('Componentes.form.text-input', [
            'type' => 'date',
            'name' => $name,
            'item' => $item,
            'class' => $class,
            'label' => $label,
            'options' => $options
        ])->render();
    }  
    
    function password($name, $label, $class, $item=null, $options=[]){

        if(!isset($options['inputclass'])){
            $options['inputclass'] = 'p-1';
        }

        return view('Componentes.form.text-input', [
            'type' => 'password',
            'name' => $name,
            'item' => $item,
            'class' => $class,
            'label' => $label,
            'options' => $options
        ])->render();
    }    


    function checkbox($name, $label, $class, $item=null, $options=[]){

        if(!isset($options['inputclass'])){
            $options['inputclass'] = 'p-1';
        }
        return view('Componentes.form.checkbox-input', [
            'type' => 'checkbox',
            'name' => $name,
            'item' => $item,
            'class' => $class,
            'label' => $label,
            'options' => $options
        ])->render();
    }
    
}