@extends('Admin.template')

@section('content')
    
{{-- FILTROS --}}
<?= $filtergen->generate('admin.mesas.index',$filtros, [
    'order' => [
        'fecha'=> 'Fecha',
        'asignatura' => 'Asignatura'
    ],
    'show' => [
        'ninguno' => 'Ninguno',
        'proximas' => 'Proximas'
    ],
    'searchField' => [
        'placeholder' => 'programacion : algebra'
    ]

]) ?>
        
        
        <div class="table">
            <div class="perfil__header-alt">
                <a href="{{route('admin.mesas.create')}}"><button class="btn_blue"><i class="ti ti-circle-plus"></i>Agregar mesa</button></a>
            </div>
        <table class="table__body">
            <thead>
                <tr>
                    
                    <th>Materia</th>
                    <th>Llamado</th>
                    <th>Carrera</th>
                    <th class="center">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mesas as $mesa)
                    <tr>
                       
                    <td>
                        
                        <p>{{$mesa->asignatura->nombre}}</p>
                    </td>
                    <td class="w-25p">
                        <p>
                            @if ($mesa->llamado == 1 || $mesa->llamado == 0)
                            Primero
                            @else
                            Segundo
                            @endif
                        </p>
                        <p>{{$formatoFecha->dmahm($mesa->fecha)}}</p>
                    </td>
                    <td>
                        <p>{{$mesa->asignatura->carrera->nombre}}</p>
                        
                        <p>Año: {{$mesa->asignatura->anio}}</p>
                    </td>
                    <td><a href="{{route('admin.mesas.edit', ['mesa' => $mesa->id])}}"><button class="btn_blue"><i class="ti ti-file-info"></i>Detalles</button></a></td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>

        <div class="w-1/2 mx-auto p-5 pagination">
            {{ $mesas->appends(request()->query())->links('Componentes.pagination') }}
        </div>
@endsection
