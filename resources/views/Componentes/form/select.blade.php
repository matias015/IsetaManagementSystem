
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

<div class="flex-col py-1 px-5">
    <label for="">{{$label}}</label>

    <select name="{{$name}}" class="{{$inputClass}}">
        @if ($firstItem)
            @foreach ($firstItem as $key=>$value)
                <option value="{{$key}}">{{$value}}</option>
            @endforeach
        @endif
        @foreach ($items as $item)
            <option @selected($default==$item->id) value="{{$item->id}}">{{$item->textForSelect()}}</option>
        @endforeach
    </select>
</div>