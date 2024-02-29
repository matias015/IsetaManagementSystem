
@php
    $default = '';

    if($item){
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

    <select name="{{$name}}" class="{{$options['inputclass']}}">
        @foreach ($optionsE as $key=>$value)
            <option @selected($default==$key) value="{{$key}}">{{$value}}</option>
        @endforeach
    </select>

</div>