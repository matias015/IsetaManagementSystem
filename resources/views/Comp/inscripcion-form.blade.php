<form method="POST" action="{{route($path)}}">
    @csrf
      
    @if ($yaAnotado)
        @if($yaAnotado->llamado == 1)
            <td class="llamado_{{$yaAnotado->llamado}}">
                <input checked name="mesa" value="{{$yaAnotado->id}}" type="radio">
                <span>{{$yaAnotado->fecha}}</span>
            </td>
    
            <td class="llamado_{{$yaAnotado->llamado}}">
                -
            </td>
        @else
            <td class="llamado_{{$yaAnotado->llamado}}">
                -
            </td>
            <td class="llamado_{{$yaAnotado->llamado}}">
                <input checked name="mesa" value="{{$yaAnotado->id}}" type="radio">
                <span>{{$yaAnotado->fecha}}</span>
            </td>
        @endif

    @else
        <td class="llamado_1">
            <input name="mesa" value="{{$materia->mesas[0]->id}}" type="radio">
            <span>{{$materia->mesas[0]->fecha}}</span>
        </td>
    
        @isset($materia->mesas[1])
            <td class="llamado_2">
            <input name="mesa" value="{{$materia->mesas[1]->id}}" type="radio">
            <span>{{$materia->mesas[1]->fecha}}</span>
            </td>
        @else
            <td class="llamado_2"> - </td>
        @endisset
    @endif

    <td>
        <button @class([
          'inscribir' => !$yaAnotado,
          'bajarse' => $yaAnotado])>
            {{$btnTexto}}
        </button>
    </td>
  </tr>
  </form>