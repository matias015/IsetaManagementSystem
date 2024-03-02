@extends('Admin.template')

@section('content')

{{-- FILTROS --}}
<?= $filtergen->generate('admin.inscriptos.index',$filtros, [
    'order' => [
        'nombre'=> 'Nombre',
        'dni' => 'Dni',
        'dni-desc' => 'Dni descendiente'
    ],
    'show' => [
        'egresados' => 'Egresados',
        'registrados' => 'Registrados'
    ],
    'searchField' => [
        'placeholder' => 'Buscar'
    ]

]) ?>



        <div class="table">
            <div class="perfil__header-alt">
                <a href="{{route('admin.inscriptos.create')}}"><button class="btn_blue"><i class="ti ti-circle-plus"></i>Agregar inscripcion</button></a>
            </div>
        <table class="table__body">
            <thead>
                <tr>
                    <th>Apellido y nombre</th>
                    {{-- <th>Dni</th> --}}
                    <th>Carrera</th>
                    <th>Periodo</th>
                    <th class="center">Acción</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($alumnos as $alumno)
            <tr>
                <td>
                    {{$alumno->apellido.' '. $alumno->nombre}}
                </td>
                
                {{-- <td>{{$alumno->dni}}</td> --}}
                <td>{{$alumno->carrera}}</td>
                <td>
                    {{$alumno->anio_inscripcion?$alumno->anio_inscripcion:'Sin datos'}}
                    -
                    {{$alumno->anio_finalizacion? $alumno->anio_finalizacion:'Presente'}}
                </td>
                
                <td class="flex just-center"><a href="{{route('admin.inscriptos.edit', ['inscripto' => $alumno->id])}}"><button class="btn_blue"><i class="ti ti-file-info"></i>Detalles</button></a></td>
                
            </tr>
            @endforeach
            </tbody>
            
            

        </table>
        </div>
        

        
        
        <div class="w-1/2 mx-auto p-5 pagination">
            {{ $alumnos->appends(request()->query())->links('Componentes.pagination') }}
        </div>    
@endsection
