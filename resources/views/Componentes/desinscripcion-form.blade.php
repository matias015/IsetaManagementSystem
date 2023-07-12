<label for="">llamado {{$mesa->llamado}}
    @if($mesa->diasHabiles >= 1) 
        <input type="radio" name="mesa" value="{{$mesa->id}}">
    @else
        Ya ha caducado el tiempo de desinscripcion    
    @endif
    
    fecha:   {{$mesa->fecha}}
</label>