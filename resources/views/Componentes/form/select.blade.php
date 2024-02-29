<select name="{{$name}}" class="{{$class}}">
    @if ($first)
        <option value="{{$first[0]}}">{{$first[1]}}</option>
    @endif
    @foreach ($items as $item)
        <option @selected(old($name)==$item->id) value="{{$item->id}}">{{$item->textForSelect()}}</option>
    @endforeach
</select>