@extends('Alumnos.layout')
@section('content')
<main id="fondo-estudiantes">
    <section class="table">
        <div class="table__header">
            <h2>Matricular</h2>
            <div><button form="formulario" class="btn_edit">Enviar</button></div>
        </div>
        <div class="table__body">
            <table class="rematriculacion">
                <thead>
                    <tr>
                        <th>Año</th>
                        <th>Asignatura</th>
                        <th class="center">Acción</th>
                    </tr>
                </thead>
                <tbody>
            <form id="formulario" method="POST" action="{{route('alumno.rematriculacion.post', ['carrera'=>$carrera])}}">
                @csrf
                
                @if (count($asignaturas)<=0)
                    <tr>
                        <span>No tienes asignaturas para rendir de esta carrera.</span>
                        <span>Si crees que se trata de un error, comunicate con la institucion para solucionarlo.</span>
                    </tr>
    
                @else
                @foreach ($asignaturas as $asignatura)
                    <tr @class([
                        'gray-600' => $asignatura->equivalencias_sin_aprobar
                        ])>
                        
                        <td> {{$asignatura->anio}}</td>
                        <td>{{$asignatura->nombre}}
                        </td>
                        <td class="flex just-end"> 
                            @if ($asignatura->equivalencias_sin_aprobar)
                                <div>  
                                    <div class="flex just-end gap-3">
                                        <p class="font-600 salto">Debes correlativas</p>
                                        <label class="blue-600 px-1 rounded pointer ver-equiv" data-element="{{$asignatura->id}}">Detalles...</label>
                                    </div>   
                                    <ul class="none id-{{$asignatura->id}}">
                                    @foreach ($asignatura->equivalencias_previas as $asignatura)
                                    <li class="salto">{{$asignatura}}</li>
                                    @endforeach
                                </ul>
                                </div>
                            @else
                                <select class="campo_info rounded pointer" name="{{$asignatura->id}}">
                                    <option value="">No matricular</option>
                                    <option value="0">Libre</option>
                                    <option value="1">Regular</option>
                                    </select>
                            @endif
                        </td>
                    </tr>
                @endforeach
                @endif
                </tbody>
            </form>
            </table>
        </div>
    </section>
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
