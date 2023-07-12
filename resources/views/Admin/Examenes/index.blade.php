@extends('Admin.template')

@section('content')

<div>
    

        <a href="{{route('admin.examenes.create')}}"><button>Inscribir alumno</button></a>

    <div>
        <form action="{{route('admin.examenes.index')}}">
            <p>filtrar</p>
                <select name="campo">
                    <option @selected($filtros['campo'] == 'principales') value="principales">Principales</option>
                    <option @selected($filtros['campo'] == 'materia') value="materia">Materia</option>
                    <option @selected($filtros['campo'] == 'dni') value="dni">Dni</option>
                    <option @selected($filtros['campo'] == 'nombre') value="nombre">Nombre</option> 
                    <option @selected($filtros['campo'] == 'apellido') value="apellido">Apellido</option>   
                    <option @selected($filtros['campo'] == 'email') value="email">Email</option> 
                    <option @selected($filtros['campo'] == 'telefonos') value="telefonos">Telefonos</option>
                    <option @selected($filtros['campo'] == 'ciudad') value="ciudad">Ciudad</option>
                </select> 
             <input value="{{$filtros['filtro']}}" name="filtro" type="text">
             <input type="submit" value="Buscar">
        </form>

        <a href="{{route('admin.examenes.index')}}"><button>Quitar filtro</button></a>
  
    </div>

    

    {{-- @foreach ($alumnos->pagr as )
        
    @endforeach
    <li class="page-item{{ $page == $alumnos->currentPage() ? ' active' : '' }}">
        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
    </li> --}}
    
    
    <table>
        <tr>
            <td>Nombre</td>
            <td>Apellido</td>
            <td>Materia</td>
            <td>Nota</td>
            <td>Acciones</td>
        </tr>

        @foreach ($examenes as $examen)
        <tr>
            <td>{{$examen->nombre}}</td>
            <td>{{$examen->apellido}}</td>
            <td>{{$examen->materia}}</td>
            <td>{{$examen->nota}}</td>
            <td><a href="{{route('admin.examenes.edit', ['examen' => $examen->id])}}"><button>editar</button></a></td>
            <td>
                <form method="POST" action="{{route('admin.examenes.destroy', ['examen' => $examen->id])}}">
                    @csrf
                    @method('delete')
                    <input type="submit" value="Eliminar">
                </form>
            </td>
        </tr>
        @endforeach

    </table>
    
    <div class="w-1/2 mx-auto p-5">
        {{ $examenes->appends(request()->query())->links('Componentes.pagination') }}
    </div>

</div>
@endsection