
@php
    $default = '';

    if($item  && isset($item->$name)){
        if(isset($options['default'])){
            $default = old($name)?old($name):$options['default'];
        }else{
            $default = $item->$name;
        }
    }else{
        if(isset($options['default'])){
            $default = old($name)?old($name):$options['default'];
        }else{
            $default = old($name)?old($name):'';
        }
    }
@endphp

<div class="{{$class}}">
    
    <label>{{$label}}</label>
    {{-- @dd($item->$name); --}}
    <textarea name="{{$name}}" class="{{$options['inputclass']}}" id="" rows="2">
        {{$default}}
    </textarea>

</div>