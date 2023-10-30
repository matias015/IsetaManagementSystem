@extends('Admin.template')
@section('content')

<main id="fondo-estudiantes" class="black flex-col justify-center items-center gap-3 p-3 w-100">
    <p class="w-100p">
        <a href="/admin/alumnos">Alumnos</a>/
        <a href="/admin/alumnos/{{$alumno->id}}/edit">{{$alumno->id}}</a>/ Rematricular/
        <a href="/admin/matricular/{{$alumno->id}}?carrera={{$carrera->id}}">{{$carrera->nombre}}</a>
    </p> 
    <p>Esta pagina sufrira cambios en el futuro ya que esta en etapa de prueba</p>

    
    <div class="perfil_one br">
        <div class="perfil__header">
            <h2>Matricular</h2>
        </div>
        <div class="perfil__info">
           
            <form  method="POST" action="{{route('admin.alumno.matricular.post', ['alumno'=>$alumno->id, 'carrera'=>$carrera->id])}}">
            @csrf

            @if (count($asignaturas)<=0)
                <div class="w-100p flex-col">
                    <span>No tienes asignaturas para rendir de esta carrera.</span>
                    <span>Si crees que se trata de un error, comunicate con la institucion para solucionarlo.</span>
                </div>
        
            @else
            @foreach ($asignaturas as $asignatura)
                <div class="w-100p flex just-between perfil_dataname">

                    <div class="flex remat" @class([
                    'gray-600' => $asignatura->equivalencias_sin_aprobar
                    ])>
                        <div class="flex">
                            <label>Año:</label> 
                            <span class="font-400">{{$asignatura->anio}}</span>
                        </div>
                        <div class="flex">
                            <label>Asignatura:</label>
                            <span class="font-400">{{$asignatura->nombre}}</span>
                        </div>
                    </div>
                    <div class="flex">
                        @if ($asignatura->equivalencias_sin_aprobar)
                        <div class="flex just-end gap-3">    
                            <p class="font-600">Debes correlativas</p>
                            <label class="blue-600 px-1 rounded pointer ver-equiv" data-element="{{$asignatura->id}}">Detalles...</label> 
                        </div>
                            <ul class="none id-{{$asignatura->id}}">
                                @foreach ($asignatura->equivalencias_previas as $asignatura)
                                    <li>{{$asignatura}}</li>
                                @endforeach
                            </ul>
                        @else
                            <select class="campo_info rounded pointer" name="{{$asignatura->id}}">
                                <option value="">No matricular</option>
                                <option value="1">Regular</option>
                                <option value="0">Libre</option>
                            </select>
                        @endif
                    </div>
                </div>
            @endforeach
            <div class="upd"><button class="m-2 rounded px-3 py-2 btn_edit">Enviar</button></div>
            @endif
            </form>
        </div>
    </div>

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
