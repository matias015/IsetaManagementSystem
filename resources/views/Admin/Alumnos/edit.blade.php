@extends('Admin.template')

@section('content')



<div class="edit-form-container">
        <p>
            <a href="/admin/alumnos">Alumnos</a>/
            <a href="/admin/alumnos/{{$alumno->id}}/edit">{{$alumno->id}}</a>
        </p>
    <div class="perfil_one br">
        <div class="perfil__header">
            <h2>Historia academica</h2>
        </div>
        <div class="perfil__info">
        <form class="grid-2" method="post" action="{{route('admin.alumnos.update', ['alumno'=>$alumno->id])}}">
        @csrf
        @method('put')
        
            <div>
                <h2 class="p-2">Alumno</h2>
                <?= $form->text('dni','DNI:','flex-col py-1 px-5',$alumno,['inputclass'=>'p-1 w-75p']) ?>
                <?= $form->text('nombre','Nombre:','flex-col py-1 px-5',$alumno,['inputclass'=>'p-1 w-75p']) ?>
                <?= $form->text('apellido','Apellido:','flex-col py-1 px-5',$alumno,['inputclass'=>'p-1 w-75p']) ?>
                <?= $form->date('fecha_nacimiento','Fecha de nacimiento:','flex-col py-1 px-5',$alumno,['default' => $alumno->fecha_nacimiento->format('Y-m-d'),'inputclass'=>'p-1 w-75p']) ?>
                <?= $form->select('estado_civil','Estado civil:','flex-col py-1 px-5',$alumno,['soltero','casado'],['inputclass'=>'p-1 w-75p']) ?>
            </div>
            <div>
                <h2 class="p-2">Dirección</h2>
                <?= $form->text('ciudad','Ciudad:','flex-col py-1 px-5',$alumno,['inputclass'=>'p-1 w-75p']) ?>
                <?= $form->text('codigo_postal','Codigo postal:','flex-col py-1 px-5',$alumno,['inputclass'=>'p-1 w-75p']) ?>
                <?= $form->text('calle','Calle:','flex-col py-1 px-5',$alumno,['inputclass'=>'p-1 w-75p']) ?>
                <?= $form->text('casa_numero','Altura:','flex-col py-1 px-5',$alumno,['inputclass'=>'p-1 w-75p']) ?>
                <?= $form->text('dpto','Departamento:','flex-col py-1 px-5',$alumno,['inputclass'=>'p-1 w-75p']) ?>
                <?= $form->text('piso','Piso:','flex-col py-1 px-5',$alumno,['inputclass'=>'p-1 w-75p']) ?>
            </div>
            <div>
                <h2 class="p-2">Contacto</h2>
                <?= $form->text('email','Email:','flex-col py-1 px-5',$alumno,['inputclass'=>'p-1 w-75p']) ?>
                <?= $form->text('telefono1','Telefono 1:','flex-col py-1 px-5',$alumno,['inputclass'=>'p-1 w-75p']) ?>
                <?= $form->text('telefono2','Telefono 2:','flex-col py-1 px-5',$alumno,['inputclass'=>'p-1 w-75p']) ?>
                <?= $form->text('telefono3','Telefono 3:','flex-col py-1 px-5',$alumno,['inputclass'=>'p-1 w-75p']) ?>
            </div>
            <div>
                <h2 class="p-2">académico</h2>
                <?= $form->text('titulo_anterior','Titulo anterior:','flex-col py-1 px-5',$alumno,['inputclass'=>'p-1 w-75p']) ?>
                <?= $form->text('becas','Becas:','flex-col py-1 px-5',$alumno,['inputclass'=>'p-1 w-75p']) ?>
            </div>
            <div>
                <h2 class="p-2">Otros</h2>
                <div class="flex-col py-1 px-5">
                    <label class="w-100p">Observaciones:</label>
                    <textarea class="p-1 w-75p" name="observaciones" rows="2">
                        {{old('observaciones')? old('observaciones'):$alumno->observaciones}}
                    </textarea>
                </div>
            </div>

            
            
           


        </div>
        <div class="upd"><button class="btn_blue"><i class="ti ti-refresh"></i>Actualizar</button></div>
       </form>
    </div>

    
    
    <div class="perfil_one br">
        <div class="perfil__header">
            <h2>Rematriculación manual</h2>
        </div>
        <div class="matricular">
            <form action="{{route('admin.alumno.rematricular',['alumno' => $alumno->id])}}">
                <select class="px-2 rounded" name="carrera" id="">
                    @foreach ($carreras as $carrera)
                        <option value="{{$carrera->id}}">{{$carrera->nombre}}</option>
                    @endforeach
                </select>
                <div class="upd"><button class="btn_blue"><i class="ti ti-paperclip"></i>Matricular</button></div>
            </form>
        </div>
    </div>
   
    

    <div class="table">
        <div class="table__header">
            <h2>Cursadas</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Materia</th>
                    {{-- <th>Año</th> --}}
                    {{-- <th>Carrera</th> --}}
                    <th>Condicion</th>
                    <th class="center">Estado</th>
                    <th class="center">Acción</th>
                </tr>
            </thead>
            <tbody class="table__body">

            @php
                $carrera_actual = "";
                $anio_actual = "";
            @endphp

            @foreach($cursadas as $cursada)

                {{-- @dd($cursada) --}}
                @if ($carrera_actual != $cursada->carrera)
                    <tr>
                        <td class="center font-600 tit-year2" colspan=5>{{$cursada->carrera}}</td>
                    </tr>
                    @php  
                        $carrera_actual = $cursada->carrera;
                        $anio_actual = "";
                    @endphp
                @endif
  

                @if ($anio_actual != $cursada->anio_asig)
                    <tr>
                        <td class="center font-600 tit-year" colspan=5>
                            Año: {{$cursada->anio_asig+1}}
                        </td>
                    </tr>
                    @php
                            $anio_actual = $cursada->anio_asig
                    @endphp
                @endif
  

                <tr>
                    <td>{{$cursada->asignatura}}</td>
                    <td>{{$cursada->condicionString()}}</td>
                    <td class="center">{{$cursada->aprobado()}}</td>
                    
                    <td class="flex just-center">
                        <a href="{{route('admin.cursadas.edit', ['cursada' => $cursada->id,])}}">
                            <button class="btn_blue"><i class="ti ti-edit"></i>Editar</button>
                        </a>
                    </td>
                </tr>
                           
            @endforeach
            </tbody>
        </table>
        
        
    </div> 

    <div class="table">
        <div class="table__header">
            <h2>Examenes</h2>
            <p>Importante: algunos examanes de alumnos mas antiguos podrian no tener datos sobre las mesas.
            </p>
        </div>
            <table class="table__body">
                <thead>
                    <tr>
                        <th>Materia</th>
                        <th>Fecha</th>
                        <th>Nota</th>
                        <th class="center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @php  
                        $carrera_actual = "";
                        $anio_actual = "";
                    @endphp

                    @foreach($examenes as $examen)

                        @if ($carrera_actual != $examen->carrera)
                            <tr>
                                <td class="center font-600 tit-year2" colspan=4>{{$examen->carrera}}</td>
                            </tr>
                            @php  
                                $carrera_actual = $examen->carrera;
                                $anio_actual = "";
                            @endphp
                        @endif
    

                        @if ($anio_actual != $examen->anio_asig)
                            <tr>
                                <td class="center font-600 tit-year" colspan=4>
                                    Año: {{$examen->anio_asig+1}}
                                </td>
                            </tr>
                            @php
                                    $anio_actual = $examen->anio_asig
                            @endphp
                        @endif

                        <tr>
                            <td>{{$examen->asignatura}}</td>
    
                            <td>
                                
                                {{$formatoFecha->dma($examen->fecha())}}
                            </td>
                            
                            <td>
                        
                            @if ($examen->aprobado==3)
                                Ausente
                            @elseif($examen->nota<=0)
                                Sin nota
                            @else
                                {{$examen->nota}}
                            @endif
                            </td>
                            <td class="flex just-center"><a href="{{route('admin.examenes.edit', ['examen' => $examen->id,])}}"><button class="btn_blue"><i class="ti ti-edit"></i>Editar</button></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
       
    </div> 
    
</div>

@endsection
