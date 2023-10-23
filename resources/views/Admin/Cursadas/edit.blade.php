@extends('Admin.template')

@section('content')
        <div class="edit-form-container">
            <div class="perfil_one br">
                <div class="perfil__header">
                    <h2>Cursada</h2>
                </div>
                <div class="perfil__info">
                    <form method="post" action="{{route('admin.cursadas.update', ['cursada'=>$cursada->id])}}">
                    @csrf
                    @method('put')

                    <div class="perfil_dataname">
                        <label>Alumno:</label>
                        <span class="campo_info2">{{$cursada->alumno->nombre.' '.$cursada->alumno->apellido}}</span>
                    </div>
                    <div class="perfil_dataname">
                        <label>Materia:</label>
                        <span class="campo_info2">{{$cursada->asignatura->nombre}}</span>
                    </div>
                    <div class="perfil_dataname">
                        <label>Año de cursada:</label>
                        <input class="campo_info rounded" value="{{$cursada->anio_cursada}}" name="anio_cursada">
                    </div>
                    <div class="perfil_dataname">
                        <label>Condicion:</label>
                        <select class="campo_info rounded" name="condicion">
                            <option @selected($cursada->condicion==0) value="0">Regular</option>
                            <option @selected($cursada->condicion==1) value="1">Libre</option>
                            <option @selected($cursada->condicion==2) value="2">Promocion</option>    
                            <option @selected($cursada->condicion==3) value="3">Equivalencia</option>
                            <option @selected($cursada->condicion==4) value="4">Desertor</option>
                        </select> 
                    </div>
                    <div class="perfil_dataname">
                        <label>Aprobada:</label>
                        <select class="campo_info rounded" name="aprobada">
                            <option @selected($cursada->aprobada==1) value="1">Si</option>
                            <option @selected($cursada->aprobada==2) value="2">No</option>
                            <option @selected($cursada->aprobada==3) value="3">Vacio/cursando</option>
                        </select>
                    </div>

                    <div class="upd">
                        <input type="submit" value="Actualizar" class="btn_borrar">
                        <form method="post" action="{{route('admin.cursadas.destroy', ['cursada'=>$cursada->id])}}">
                        @csrf
                        @method('delete')
                        <input type="submit" value="Borrar" class="btn_borrar">
                        </form>
                    </div>
                    </form>
                </div>
            </div>
        </div>

@endsection
