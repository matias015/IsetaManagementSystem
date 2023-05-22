<label for="">llamado {{$mesa->llamado}}
    @if($mesa->diasHabiles >= 2)
        <input type="radio" name="mesa" value="{{$mesa->id}}">
    @else
        Ya ha caducado el tiempo de inscripcion    
    @endif

    fecha:   {{$mesa->fecha}}
</label>