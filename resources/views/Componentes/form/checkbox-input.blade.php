
@php
    $default = '';
    
    
    if($item && isset($item->$name)){
        if(old($name) == 1) $default = true;
        else if($item && isset($item->$name) && $item->$name==1) $default = true;
    }
    else{
        if(isset($options['default'])){
            if(old($name) == 1) $default = true;
            else $default = $options['default'];
        }
    }
@endphp

{{-- @dd($item->filter_vigente) --}}

<div class="{{$class}}">
    
    <label>{{$label}}</label>
    {{-- @dd($item->$name); --}}
    @if ($item)
        <input @checked($default) value="1" type="{{$type}}" name="{{$name}}" class="{{$options['inputclass']}}">        
    @else
        <input @checked($default) value="1" type="{{$type}}" name="{{$name}}" class="{{$options['inputclass']}}">        
    @endif

</div>