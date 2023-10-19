@extends('Admin.template')

@section('content')
    <div>


        <div class="edit-form-container">
            <div class="perfil_one table">
                <form method="post" action="{{route('admin.cursadas.update', ['cursada'=>$cursada->id])}}">
                @csrf
                @method('put')

                    <span class="perfil_dataname">Alumno: {{$cursada->alumno->nombre.' '.$cursada->alumno->apellido}}</span>
                    <span class="perfil_dataname">Materia: {{$cursada->asignatura->nombre}}</span>
                    <span class="perfil_dataname">Año de cursada: <input class="campo_info" value="{{$cursada->anio_cursada}}" name="anio_cursada"></span>
                    <span class="perfil_dataname">Condicion: 
                        <select class="campo_info" name="condicion">
                            <option @selected($cursada->condicion==0) value="0">Regular</option>
                            <option @selected($cursada->condicion==1) value="1">Libre</option>
                            <option @selected($cursada->condicion==2) value="2">Promocion</option>    
                            <option @selected($cursada->condicion==3) value="3">Equivalencia</option>
                            <option @selected($cursada->condicion==4) value="4">Desertor</option>
                        </select>    
                    </span>
                    
                    <span class="perfil_dataname">Aprobada:
                        <select class="campo_info" name="aprobada">
                            <option @selected($cursada->aprobada==1) value="1">Si</option>
                            <option @selected($cursada->aprobada==2) value="2">No</option>
                            <option @selected($cursada->aprobada==3) value="3">Vacio/cursando</option>
                        </select>    
                    </span>

                    <div class="upd"><input type="submit" value="Actualizar" class="btn_borrar"></div>
                </form>

                <form method="post" action="{{route('admin.cursadas.destroy', ['cursada'=>$cursada->id])}}">
                    @csrf
                    @method('delete')
                    <div class="upd"><input type="submit" value="Borrar cursada" class="btn_borrar wit2"></div>
                </form>
       
            </div>

        </div>
</div>

@endsection
