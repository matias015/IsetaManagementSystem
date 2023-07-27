@extends('Alumnos.layout')
@section('content')
<div class="p-2">
    <form method="POST" action="{{route('alumno.rematriculacion.post', ['carrera'=>$asignaturas[0]->id_carrera])}}">
        @csrf

        @foreach ($asignaturas as $asignatura)
        
            <div class="w-100p grid-2">
                
                <span @class([
                    'gray-600' => $asignatura->equivalencias_sin_aprobar
                ])>
                    <span>Año: {{$asignatura->anio+1}}</span> {{$asignatura->nombre}}
                </span>
                <span>
                    @if ($asignatura->equivalencias_sin_aprobar)
                    <div class="flex gap-3">    
                        <p class="font-600">Debes equivalencias</p>
                        <span class="blue-600 px-1 rounded pointer ver-equiv" data-element="{{$asignatura->id}}">detalles...</span> 
                    </div>
                        <ul class="none id-{{$asignatura->id}}">
                            @foreach ($asignatura->equivalencias_previas as $asignatura)
                                <li>{{$asignatura}}</li>
                            @endforeach
                        </ul>
                    @else
                        <select name="{{$asignatura->id}}">
                            <option selected value="0"></option>
                            <option value="1">Presencial</option>
                            <option value="2">Libre</option>
                        </select>
                    @endif
                </span>
            </div>
            <hr>
        @endforeach
        <button>Enviar</button>
    </form>
</div>
<script>
    const button = document.querySelector('#ver-equiv')
    window.onclick = function(e){
        if(!e.target.classList.contains('ver-equiv')) return
        let id = e.target.dataset.element
        let list = document.querySelector('.id-'+id)
        console.log(list);
        list.classList.toggle('none')
    }
</script>
@endsection