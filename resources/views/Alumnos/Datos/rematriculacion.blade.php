@extends('Alumnos.layout')
@section('content')
<main id="fondo-estudiantes" class="black flex-col justify-center items-center gap-3 p-3 w-100">

    <form class=" w-75p p-5 my-10 flex-col items-end just-center rounded-3  box-sh" method="POST" action="{{route('alumno.rematriculacion.post', ['carrera'=>$carrera])}}">
        @csrf

        @if (count($asignaturas)<=0)
        <div class="w-100p flex-col">
                
            <span>No tienes asignaturas para rendir de esta carrera.</span>
            
            <span>Si crees que se trata de un error, comunicate con la institucion para solucionarlo.</span>

        </div>
        <hr>
        @else
        @foreach ($asignaturas as $asignatura)
            <div class="w-100p flex just-between">
                
                <span @class([
                    'gray-600' => $asignatura->equivalencias_sin_aprobar
                ])>
                    <span class="font-600">Año: {{$asignatura->anio+1}}</span> 
                    <span>Asignatura: {{$textFormatService->ucfirst($asignatura->nombre)}}</span>
                </span>
                <span>
                    @if ($asignatura->equivalencias_sin_aprobar)
                    <div class="flex just-end gap-3">    
                        <p class="font-600">Debes correlativas</p>
                        <span class="blue-600 px-1 rounded pointer ver-equiv" data-element="{{$asignatura->id}}">Detalles...</span> 
                    </div>
                        <ul class="none id-{{$asignatura->id}}">
                            @foreach ($asignatura->equivalencias_previas as $asignatura)
                                <li>{{$asignatura}}</li>
                            @endforeach
                        </ul>
                    @else
                        <select name="{{$asignatura->id}}">
                            <option></option>
                            <option value="0">Libre</option>
                            <option value="1">Regular</option>
                        </select>
                    @endif
                </span>
            </div>
            <hr>
        @endforeach
        <button class="m-2 rounded px-3 py-2 btn_edit">Enviar</button>
        @endif

        
    </form>

</main>

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
