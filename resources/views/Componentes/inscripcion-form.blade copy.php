<form method="POST" action="{{route($path)}}">
    @csrf
      
    {{-- Si ya esta anotado en la carrera, que muestre el formulario para bajarse --}}
    @if ($yaAnotado)
        @if($yaAnotado->llamado == 1)

            <td class="llamado_{{$yaAnotado->llamado}}">
                <input checked name="mesa" value="{{$yaAnotado->id}}" type="radio">
                <span>{{$fomatoFecha->d_m_h_m($yaAnotado->fecha)}}</span>
            </td>
    
            <td class="llamado_{{$yaAnotado->llamado}}"> - </td>

        @else

            <td class="llamado_{{$yaAnotado->llamado}}"> - </td>
            
            <td class="llamado_{{$yaAnotado->llamado}}">
                <input checked name="mesa" value="{{$yaAnotado->id}}" type="radio">
                <span>{{$formatoFecha->d_m_h_m($yaAnotado->fecha)}}</span>
            </td>

        @endif

    @else
    {{-- Sino esta anotado en la carrera, que muestre el formulario para anotarse --}}

        {{-- Orden de las mesas [llamado1,llamado2] o [null,llamado2] o [llamado1,null] --}}
        @php
            $mesas = [null, null];
            foreach ($materia->mesas as $mesa) {
                $mesas[($mesa->llamado)-1] = $mesa;
            }    
        @endphp
  
        {{-- Si hay llamado 1 para esa mesa se muestra, sino, muestra un mensaje --}}
        @if ($mesas[0])
            <td class="llamado_1">
                <input name="mesa" value="{{$mesas[0]->id}}" type="radio">
                {{$formatoFecha->d_m_h_m($mesas[0]->fecha)}}
            </td>
        @else
            <td>No hay llamado 1</td>
        @endif

        {{-- Lo mismo para llamado 2 --}}
        @if ($mesas[1])
            <td class="llamado_2">
                <input name="mesa" value="{{$mesas[1]->id}}" type="radio">
                {{$formatoFecha->d_m_h_m($mesas[1]->fecha)}}
            </td>
        @else
            <td>No hay llamado 2</td>
        @endif
        
    @endif

    {{-- Boton cambia de clase y texto dependiendo si esta anotado o no --}}
    <td>
        <button @class([
          'boton-finales inscribir' => !$yaAnotado,
          'boton-finales bajarse' => $yaAnotado])>
            {{$btnTexto}}
        </button>
    </td>
  </tr>
  </form>
