@extends('Admin.template')

@section('content')
    <div>
        <div class="perfil_one br">
            <div class="perfil__header">
                <h2>Crear nuevo alumno/a</h2>
            </div>
            <div class="perfil__info">
                <form class="grid-2" method="post" action="{{route('admin.alumnos.store')}}">
                @csrf
                    
                <div class="flex-col gap-2 p-2">                    
                    <h2 class="p-2">Alumno</h2>
                    <?= $form->text('dni','DNI:','label-input-y-75',null) ?>
                    <?= $form->text('nombre','Nombre:','label-input-y-75',null) ?>
                    <?= $form->text('apellido','Apellido:','label-input-y-75',null) ?>
                    <?= $form->date('fecha_nacimiento','Fecha de nacimiento:','label-input-y-75',null) ?>
                    <?= $form->select('estado_civil','Estado civil:','label-select-y',null,['soltero','casado']) ?>
                </div>
                <div class="flex-col gap-2 p-2">
                    <h2 class="p-2">Dirección</h2>
                    <?= $form->text('ciudad','Ciudad:','label-input-y-75',null) ?>
                    <?= $form->text('codigo_postal','Codigo postal:','label-input-y-75',null) ?>
                    <?= $form->text('calle','Calle:','label-input-y-75',null) ?>
                    <?= $form->text('casa_numero','Altura:','label-input-y-75',null) ?>
                    <?= $form->text('dpto','Departamento:','label-input-y-75',null) ?>
                    <?= $form->text('piso','Piso:','label-input-y-75',null) ?>
                </div>
                <div class="flex-col gap-2 p-2">
                    <h2 class="p-2">Contacto</h2>
                    <?= $form->text('email','Email:','label-input-y-75',null) ?>
                    <?= $form->text('telefono1','Telefono 1:','label-input-y-75',null) ?>
                    <?= $form->text('telefono2','Telefono 2:','label-input-y-75',null) ?>
                    <?= $form->text('telefono3','Telefono 3:','label-input-y-75',null) ?>
                </div>
                <div class="flex-col gap-2 p-2">
                    <h2 class="p-2">académico</h2>
                    <?= $form->text('titulo_anterior','Titulo anterior:','label-input-y-75',null) ?>
                    <?= $form->text('becas','Becas:','label-input-y-75',null) ?>
                </div>
                <div class="flex-col gap-2 p-2">
                    <h2 class="p-2">Otros</h2>
                    <div class="flex-col py-1 px-5">
                        <label class="w-100p">Observaciones:</label>
                        <textarea class="p-1 w-75p" name="observaciones" rows="2">
                            {{old('observaciones')? old('observaciones'):''}}
                        </textarea>
                    </div>
                </div>

                    <div class="upd"><button class="btn_blue"><i class="ti ti-circle-plus"></i>Crear</button></div>
                </form>
            </div>
        </div>
    </div>
@endsection
