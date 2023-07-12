@extends('Admin.template')

@section('content')

    <div>
        

    
            <a href="{{route('admin.asignaturas.create')}}"><button>Agregar carrera</button></a>

        <div>
            <form action="{{route('admin.asignaturas.index')}}">
                <p>filtrar</p> 
                 <input  name="filtro" type="text">
                 <input type="submit" value="Buscar">
            </form>

            <a href="{{route('admin.asignaturas.index')}}"><button>Quitar filtro</button></a>
      
        </div>

        

        {{-- @foreach ($alumnos->pagr as )
            
        @endforeach
        <li class="page-item{{ $page == $alumnos->currentPage() ? ' active' : '' }}">
            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
        </li> --}}
        

        <table>
            <tr>
                <td>Nombre</td>
                <td>carrera</td>

                <td>Acciones</td>
            </tr>

            @foreach ($asignaturas as $asignatura)
            <tr>
                <td>{{$textFormatService->utf8Minusculas($asignatura->nombre)}}</td>
                <td>{{$textFormatService->utf8UpperCamelCase($asignatura->carrera->nombre)}}</td>
                <td><a href="{{route('admin.asignaturas.edit', ['asignatura' => $asignatura->id])}}"><button>editar</button></a></td>
                <td>
                    <form method="POST" action="{{route('admin.asignaturas.destroy', ['asignatura' => $asignatura->id])}}">
                        @csrf
                        @method('delete')
                        <input type="submit" value="Eliminar">
                    </form>
                </td>
            </tr>
            @endforeach

        </table>
        
        <div class="w-1/2 mx-auto p-5">
            {{ $asignaturas->appends(request()->query())->links('Componentes.pagination') }}
        </div>

    </div>
    
@endsection