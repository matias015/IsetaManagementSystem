@extends('Admin.template')

@section('content')

    <div>
        <script src="https://cdn.tailwindcss.com"></script>

    
            <a href="{{route('admin.carreras.create')}}"><button>Agregar carrera</button></a>

        <div>
            <form action="{{route('admin.carreras.index')}}">
                <p>filtrar</p> 
                 <input  name="filtro" type="text">
                 <input type="submit" value="Buscar">
            </form>

            <a href="{{route('admin.carreras.index')}}"><button>Quitar filtro</button></a>
      
        </div>

        

        {{-- @foreach ($alumnos->pagr as )
            
        @endforeach
        <li class="page-item{{ $page == $alumnos->currentPage() ? ' active' : '' }}">
            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
        </li> --}}
        

        <table>
            <tr>
                <td>Nombre</td>
                <td>Resolucion</td>
                <td>Apertura</td>
                <td>Acciones</td>
            </tr>

            @foreach ($carreras as $carrera)
            <tr>
                <td>{{$textFormatService->utf8Minusculas($carrera->nombre)}}</td>
                <td>{{$textFormatService->utf8UpperCamelCase($carrera->resolucion)}}</td>
                <td>{{$carrera->anio_apertura}}</td>
                <td>{{!$carrera->anio_fin? 'Vigente':$carrera->anio_fin}}</td>
                <td>{{!trim($carrera->observaciones)? 'Sin observaciones': $carrera->observaciones}}</td>
                <td><a href="{{route('admin.carreras.edit', ['carrera' => $carrera->id])}}"><button>editar</button></a></td>
                <td>
                    <form method="POST" action="{{route('admin.carreras.destroy', ['carrera' => $carrera->id])}}">
                        @csrf
                        @method('delete')
                        <input type="submit" value="Eliminar">
                    </form>
                </td>
            </tr>
            @endforeach

        </table>
        
        <div class="w-1/2 mx-auto p-5">
            {{ $carreras->appends(request()->query())->links() }}
        </div>

    </div>
    
@endsection