
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
    @if (!$label)
        <label for="">{{$label}}</label>
    @endif

    <select name="{{$name}}" >
        @if ($firstItems)
            @foreach ($firstItems as $key=>$value)
                <option value="{{$key}}">{{$value}}</option>
            @endforeach
        @endif
        @foreach ($items as $item)
            <option @selected($default==$item->id) value="{{$item->id}}">{{$item->textForSelect()}}</option>
        @endforeach
    </select>
</div>