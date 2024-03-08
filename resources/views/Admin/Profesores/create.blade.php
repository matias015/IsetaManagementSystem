@extends('Admin.template')

@section('content')
    <div>
        <div class="perfil_one br">
            <div class="perfil__header">
                <h2>Crear nuevo profesor/a</h2>
            </div>
            <div class="perfil__info">
                <?= $form->generate(route('admin.profesores.store'),'post',[
                    'Profesor' => [
                        $form->text('dni','DNI:','label-input-y-75',null),
                        $form->text('nombre','Nombre:','label-input-y-75',null),
                        $form->text('apellido','Apellido:','label-input-y-75',null),
                        $form->date('fecha_nacimiento','Fecha de nacimiento:','label-input-y-75',null),
                        $form->select('estado_civil','Estado civil:','label-input-y-75',null,['soltero','casado'])
                    ], 'Dirección' => [
                        $form->text('ciudad','Ciudad:','label-input-y-75',null),
                        $form->text('codigo_postal','Codigo postal:','label-input-y-75',null),
                        $form->text('calle','Calle:','label-input-y-75',null),
                        $form->text('numero','Altura:','label-input-y-75',null),
                        $form->text('departamento','Departamento:','label-input-y-75',null),
                        $form->text('piso','Piso:','label-input-y-75',null)
                    ], 'Academico' => [
                        $form->text('formacion_academica','Formacion academica:','label-input-y-75',null),
                        $form->text('anio_ingreso','Año de ingreso:','label-input-y-75',null)
                    ], 'Contacto' => [
                        $form->text('email','Email:','label-input-y-75',null),
                        $form->text('telefeono1','Telefeono 1:','label-input-y-75',null),
                        $form->text('telefeono2','Telefeono 2:','label-input-y-75',null),
                        $form->text('telefeono3','Telefeono 3:','label-input-y-75',null)
                    ], 'Otros' => [
                        $form->textarea('observaciones', 'Observaciones:', 'label-input-y-75', null)
                    ]

                ]) ?>
            </div>
        </div>
    </div>
@endsection
