@extends('Admin.template')

@section('content')
    {{-- FILTROS --}}
<?= $filtergen->generate('admin.cursadas.index',$filtros, [
    'order' => [
        'creacion'=> 'Creacion',
        'fecha' => 'Fecha',
        'asignatura'=> 'Asignatura'
    ],
    'show' => [
        // 'ninguno' => 'Todas',    
        // 'nuevas' => 'Nuevas' 
    ],
    'searchField' => [
        'placeholder' => 'programacion : Lopez'
    ]
]) ?>
       
        

        <div class="table">
            <div class="perfil__header-alt">
                <a href="{{route('admin.cursadas.create')}}"><button class="btn_blue"><i class="ti ti-circle-plus"></i>Agregar cursada</button></a>
            </div>
        <table class="table__body">
            <thead>
                <tr>
                    <th>Materia</td>
                    <th>Alumno/a</td>
                    <th>Estado</td>
                    <th class="center">Acción</th>
                </tr>
            </thead>
            
            <tbody>
            @foreach ($cursadas as $cursada)
            <tr>
                <td>{{$cursada->asignatura}}</td>
                
                <td>{{$cursada->alumno_nombre.' '.$cursada->alumno_apellido}}</td>
                <td>
                    {{$cursada->aprobado()}}
                </td>
                <td class="flex just-center"><a href="{{route('admin.cursadas.edit', ['cursada' => $cursada->id])}}"><button class="btn_blue"><i class="ti ti-file-info"></i>Detalles</button></a></td>
                

            </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        
        <div class="w-1/2 mx-auto p-5 pagination">
            {{ $cursadas->appends(request()->query())->links('Componentes.pagination') }}
        </div> 
@endsection
