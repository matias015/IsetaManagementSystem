@extends('Admin.template')

@section('content')
<div class="edit-form-container">
    <div class="perfil_one br">
        <div class="perfil__header">
            <h2>Ficha examen</h2>
        </div>
        <div class="perfil__info">
            <form method="post" action="{{route('admin.examenes.update', ['examen'=>$examen->id])}}">
            @csrf
            @method('put')
            <div class="perfil_tit_dataname rounded">
                <h3>Alumno/a</h3>
            </div>
            <div class="perfil_dataname border-none">
                <label>Alumno:</label>
                <span class="campo_info2">{{$examen->alumno->nombre}}</span>
            </div>
            <div class="perfil_tit_dataname rounded">
                <h3>Asignatura</h3>
            </div>
            <div>
                <div class="perfil_dataname">
                    <label>Materia:</label>
                    <span class="campo_info2">{{$examen->asignatura->nombre}}</span>
                </div>
                <div class="perfil_dataname">
                    <label>Carrera:</label>
                    <span class="campo_info2">{{$examen->asignatura->carrera->nombre}}</span>
                </div>
                <div class="perfil_dataname border-none">
                    <label>Año</label>
                    <span class="campo_info2">{{$examen->asignatura->anio +1}}</span>
                </div>
            </div>
            <div class="perfil_tit_dataname rounded">
                <h3>Mesa</h3>
            </div>
            <div class="campo_info4">
                @if (isset($examen->mesa))
                    <p>Presidente: @if($examen->mesa->profesor) 
                        {{$examen->mesa->profesor->nombre . ' '.$examen->mesa->profesor->apellido}}
                @else
                    Sin profesor confirmado
                @endif  
                    </p>
                    <p>vocal1: {{$examen->mesa->vocal1? $examen->mesa->vocal1->nombre . ' ' . $examen->mesa->vocal1->apellido : 'No hay'}}</p>
                    <p>vocal2: {{$examen->mesa->vocal2? $examen->mesa->vocal2->nombre . ' ' . $examen->mesa->vocal2->apellido : 'No hay'}}</p>
                    <p>llamado: {{$examen->mesa->llamado? $examen->mesa->llamado : 'No hay datos sobre el llamado'}}</p>
                    <p>llamado: {{$examen->mesa->fecha? $examen->mesa->fecha : 'No hay datos sobre la fecha'}}</p>
                @else
                    <p>No hay informacion de la mesa, esto es debido a que cuando se registro la inscripcion, no se especifico una mesa por parte de iseta</p>    
                @endif
            </div>
            <div class="perfil_tit_dataname rounded">
                <h3>Examen</h3>
            </div>
            <div>
                <div class="perfil_dataname">
                    <label>Fecha:</label>
                    <span class="campo_info2">{{$examen->fecha? $examen->fecha : 'Sin rendir'}}</span>
                </div>
                <div class="perfil_dataname">
                    <label>Nota:</label>
                    <input class="campo_info rounded" name="nota" value="{{$examen->nota}}">
                </div>
                <div class="perfil_dataname">
                    <label>Ausente</label>
                    <input class="campo_info3" @checked($examen->aprobado == 3) name="ausente" type="checkbox">
                </div>
                <div class="perfil_dataname">
                    <label>Tipo de final:</label>      
                    <select class="campo_info rounded" name="tipo_final">
                        <option value="1">Escrito</option >
                        <option value="2">Oral</option>
                        <option value="3">Promocionado</option> 
                    </select>
                </div>
                <div class="perfil_dataname">
                    <label>Libro:</label>
                    <input class="campo_info" name="libro" value="{{$examen->libro}}">
                </div>
                <div class="perfil_dataname">
                    <label>Acta:</label>
                    <input class="campo_info" name="acta" value="{{$examen->acta}}">
                </div>
            </div>
        
            <div class="upd"><input type="submit" value="Actualizar" class="btn_borrar"></div>
            </form>

            @if ($examen->borrable)
                <form class="form-eliminar" method="post" action="{{route('admin.examenes.destroy', ['examen'=>$examen->id])}}">
                    @csrf
                    @method('delete')
                    <input type="submit" value="Borrar registro de examen">
                </form>    
            @endif
        </div>
    </div>
</div>

<script src="{{asset('js/confirmacion.js')}}"></script>

@endsection
