@extends('Admin.template')

@section('content')
    <div class="edit-form-container">
        <div class="perfil_one br">
            <div class="perfil__header">
                <h2>Ficha profesor/a</h2>
            </div>
            <div class="perfil__info">
                <form class="grid-2" method="post" action="{{route('admin.profesores.update', ['profesor'=>$profesor->id])}}">
                    @csrf
                    @method('put')
                    <div>
                        <h2 class="p-2">Personal</h2>
                        <?= $form->text('dni','DNI:','flex-col py-1 px-5',$profesor,['inputclass'=>'p-1 w-75p']) ?>
                        <?= $form->text('nombre','Nombre:','flex-col py-1 px-5',$profesor,['inputclass'=>'p-1 w-75p']) ?>
                        <?= $form->text('apellido','Apellido:','flex-col py-1 px-5',$profesor,['inputclass'=>'p-1 w-75p']) ?>
                        <?= $form->date('fecha_nacimiento','Fecha de nacimiento:','flex-col py-1 px-5',$profesor,['default'=>$profesor->fecha_nacimiento->format('Y-m-d'),'inputclass'=>'p-1 w-75p']) ?>
                        <?= $form->select('estado_civil','Estado civil:','flex-col py-1 px-5',$profesor,['soltero','casado'],['inputclass'=>'p-1 w-75p']) ?>
                    </div>
                    <div>
                        <h2 class="p-2">Dirección</h2>
                        <?= $form->text('ciudad','Ciudad:','flex-col py-1 px-5',$profesor,['inputclass'=>'p-1 w-75p']) ?>
                        <?= $form->text('codigo_postal','Codigo postal 3:','flex-col py-1 px-5',$profesor,['inputclass'=>'p-1 w-75p']) ?>
                        <?= $form->text('calle','Calle:','flex-col py-1 px-5',$profesor,['inputclass'=>'p-1 w-75p']) ?>
                        <?= $form->text('numero','Altura:','flex-col py-1 px-5',$profesor,['inputclass'=>'p-1 w-75p']) ?>
                        <?= $form->text('departamento','Departamento:','flex-col py-1 px-5',$profesor,['inputclass'=>'p-1 w-75p']) ?>
                        <?= $form->text('piso','Piso:','flex-col py-1 px-5',$profesor,['inputclass'=>'p-1 w-75p']) ?>
                    </div>
                    <div>
                        <h2 class="p-2">Académico</h2>
                        <?= $form->text('formacion_academica','Formacion academica:','flex-col py-1 px-5',$profesor,['inputclass'=>'p-1 w-75p']) ?>
                        <?= $form->text('anio_ingreso','Año de ingreso:','flex-col py-1 px-5',$profesor,['inputclass'=>'p-1 w-75p']) ?>    
                    </div>
                    <div>
                        <h2 class="p-2">Contacto</h2>
                        <?= $form->text('email','Email:','flex-col py-1 px-5',$profesor,['inputclass'=>'p-1 w-75p']) ?>
                        <?= $form->text('telefeono1','Telefeono 1:','flex-col py-1 px-5',$profesor,['inputclass'=>'p-1 w-75p']) ?>
                        <?= $form->text('telefeono2','Telefeono 2:','flex-col py-1 px-5',$profesor,['inputclass'=>'p-1 w-75p']) ?>
                        <?= $form->text('telefeono3','Telefeono 3:','flex-col py-1 px-5',$profesor,['inputclass'=>'p-1 w-75p']) ?>
                    </div>
                    <div>
                        <h2 class="p-2">Otros</h2>
                        <div class="flex-col py-1 px-5">
                            <label>Observaciones:</label>
                            <textarea class="p-1 w-75p" value="{{$profesor->observaciones}}" name="observaciones" rows="2"></textarea>
                        </div>
                    </div>
                    

                    
                    


                    

                    
                    
                   
                    
                
                </div>
                <div class="upd"><button class="btn_blue"><i class="ti ti-refresh"></i>Actualizar</button></div>
            </form>
        </div>

        <div class="table">
            <div  class="table__header"><h2>Proximas mesas</h2></div>
            <table class="table__body">
                <thead>
                    <tr>
                        <th>Asignatura</th>
                        <th>Fecha</th>
                        <th>Rol</th>
                        <th class="center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($mesas as $mesa)
                    <tr>
                        <td>{{$mesa->asignatura->nombre}}</td>
                        <td>{{$formatoFecha->dmhm($mesa->fecha)}}</td>
                        <td>
                            @if ($mesa->prof_presidente == $profesor->id)
                                Presidente
                            @elseif ($mesa->prof_vocal_1 == $profesor->id)
                                Vocal 1
                            @elseif ($mesa->prof_vocal_2 == $profesor->id)
                                Vocal 2
                            @endif
                        </td>
                        <td class="flex just-center"><a href="{{route('admin.mesas.edit',['mesa'=>$mesa->id])}}"><button class="btn_blue"><i class="ti ti-file-info"></i>Detalles</button></a></td>
                    </tr>
                    @endforeach
                </tbody>           
            </table>

        </div>   
    
    </div>
@endsection
