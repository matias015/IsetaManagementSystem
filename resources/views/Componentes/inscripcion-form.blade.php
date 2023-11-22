    @if ($correlativas || !$config['alumno_puede_anotarse_mesa'])
        <div method="GET" action="">
    @else
        <form method="POST" action="{{route($path)}}">
    @endif

    @csrf
      
    {{-- Si ya esta anotado en la carrera, que muestre el formulario para bajarse --}}
    @if ($yaAnotado)
        {{-- @dd($disponibles) --}}
        @if($yaAnotado->llamado == 1)

            <td data-label="Llamado 1" class="llamado_{{$yaAnotado->llamado}}">
                <input checked name="mesa" value="{{$yaAnotado->id}}" type="radio">
                <span>{{$formatoFecha->dmhm($yaAnotado->fecha)}}</span>
            </td>
    
            <td data-label="LLamado 2" class="llamado_{{$yaAnotado->llamado}}"> - </td>

        @else

            <td data-label="LLamado 1" class="llamado_{{$yaAnotado->llamado}}"> - </td>
            
            <td data-label="Llamado 2" class="llamado_{{$yaAnotado->llamado}}">
                <input checked name="mesa" value="{{$yaAnotado->id}}" type="radio">
                <span>{{$formatoFecha->dmhm($yaAnotado->fecha)}}</span>
            </td>

        @endif

    @else
    {{-- Sino esta anotado en la carrera, que muestre el formulario para anotarse --}}

        {{-- Orden de las mesas [llamado1,llamado2] o [null,llamado2] o [llamado1,null] --}}

        @php
            $mesas = [null, null];
            foreach ($asignatura->mesas as $mesa) {
                $mesas[($mesa->llamado)-1] = $mesa;
            }    
        @endphp
  
        {{-- Si hay llamado 1 para esa mesa se muestra, sino, muestra un mensaje --}}
        @foreach ($mesas as $key=>$mesa)
            @if ($correlativas)
                <td data-label="Llamado 1">Debes correlativas</td>
                <td data-label="Llamado 2">
                    @foreach ($correlativas as $correlativa)
                        <div>-> {{$correlativa->nombre}}</div>
                    @endforeach
                </td>        
                @break        
            @elseif ($mesa)
                <td data-label="LLamado {{$key +1}}" class="llamado_1">
                    @if ($config['alumno_puede_anotarse_mesa'])
                        <input name="mesa" value="{{$mesa->id}}" type="radio">
                    @endif
                    {{$formatoFecha->dmhm($mesa->fecha)}}
                </td>
            @else
                <td data-label="LLamado {{$key +1}}">No hay llamado {{$key +1}}</td>
            @endif
        @endforeach
        
    @endif

    {{-- Boton cambia de clase y texto dependiendo si esta anotado o no --}}
    <td data-label="Acción">
        @if ($config['alumno_puede_anotarse_mesa'])        
            <button @class([
                'boton-finales inscribir' => (!$yaAnotado && !$correlativas),
                'boton-finales bajarse' => $yaAnotado,
                'boton-finales bg-gray-200 black' => $correlativas
                ])>
                {{$btnTexto}}
            </button>
        @else
            <button class="boton-finales bg-gray-200 black">
               Deshabilitado
            </button>
        @endif
        </td>
    </tr>
    
    @if ($correlativas || !$config['alumno_puede_anotarse_mesa'])
        </div>
    @else
        </form>
    @endif
