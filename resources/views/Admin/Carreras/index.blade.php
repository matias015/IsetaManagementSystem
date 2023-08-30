@extends('Admin.template')

@section('content')

<div>
    


        <a href="{{route('admin.carreras.create')}}"><button>Agregar carrera</button></a>

    <div>
        <form action="{{route('admin.carreras.index')}}">
            <p>filtrar</p> 
             <input value="{{$filtro}}" name="filtro" type="text">
             <input type="submit" value="Buscar">
        </form>

        <a href="{{route('admin.carreras.index')}}"><button>Quitar filtro</button></a>
  
    </div>

</div>

    {{-- @foreach ($alumnos->pagr as )
        
    @endforeach
    <li class="page-item{{ $page == $alumnos->currentPage() ? ' active' : '' }}">
        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
    </li> --}}
    
    <div class="table">
    <table class="table__body">
        <thead>
            <tr>
                <th>Carrera</td>
                <th>Resolucion</td>
                <th>Apertura</td>
                <th>Fin</td>
                <th>Observaciones</td>
                <th colspan="2">Acciones</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($carreras as $carrera)
            <tr>
                <td>{{$textFormatService->utf8Minusculas($carrera->nombre)}}</td>
                <td>{{$carrera->resolucion}}</td>
                <td>{{$carrera->anio_apertura}}</td>
                <td>{{$carrera->anio_fin}}</td>
                <td>{{$carrera->observaciones}}</td>
                <td><a href="{{route('admin.carreras.edit', ['carrera' => $carrera->id])}}"><button class="btn_edit">editar</button></a></td>
                <td>
                    <form method="POST" action="{{route('admin.carreras.destroy', ['carrera' => $carrera->id])}}">
                        @csrf
                        @method('delete')
                        <input class="btn_borrar" type="submit" value="Eliminar">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    
    <div class="w-1/2 mx-auto p-5 pagination">
        {{ $carreras->appends(request()->query())->links('Componentes.pagination') }}
    </div>


@endsection
