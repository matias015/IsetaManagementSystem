@extends('Admin.template')

@section('content')


        <div class="hhh">
            <a href="{{route('admin.egresados.create')}}"><button>Agregar alumno</button></a>
            
            
                <form class="form-hh" action="{{route('admin.egresados.index')}}">
                    <div class="alumnos_filtrar">
                    <br>
                    <p>filtrar</p> 
                        <select name="campo">
                            <option value="ninguno">ninguno</option>
                            <option @selected($filtros['campo'] == 'nombre-apellido') value="nombre-apellido">nombre/apellido</option>
                            <option @selected($filtros['campo'] == 'dni') value="dni">dni</option>
                            <option @selected($filtros['campo'] == 'email') value="email">email</option>
                            <option @selected($filtros['campo'] == 'cursando') value="cursando">cursando</option>
                            <option @selected($filtros['campo'] == 'registrados') value="registrados">registrados</option>
                        </select>
        
                        <input value="{{$filtros['filtro']}}" name="filtro" type="text">
                    <p>ordenar</p>
                    <select name="orden">
                        <option @selected($filtros['orden'] == 'nombre') value="nombre">nombre</option>
                        <option @selected($filtros['orden'] == 'dni') value="dni">dni</option>
                        <option @selected($filtros['orden'] == 'dni-desc') value="dni-desc">dni descendiente</option>

                    </select>
                    <br><br>
                    <input type="submit" value="Buscar">
                    </div>
                </form>
            
                
            <br>
            <a href="{{route('admin.egresados.index')}}"><button>Quitar filtro</button></a>

            
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
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Dni</th>
                    <th>Carrera</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($alumnos as $alumno)
            <tr>
                <td>{{$textFormatService->utf8UpperCamelCase($alumno->nombre)}}</td>
                <td>{{$textFormatService->utf8UpperCamelCase($alumno->apellido)}}</td>
                <td>{{$alumno->dni}}</td>
                <td>{{$textFormatService->utf8minusculas($alumno->carrera)}}</td>

                <td><a href="{{route('admin.alumnos.edit', ['alumno' => $alumno->id])}}"><button>Ver alumno</button></a></td>
                <td>
                    <form method="POST" action="{{route('admin.egresados.destroy', ['egresado' => $alumno->id])}}">
                        @csrf
                        @method('delete')
                        <input type="submit" value="Eliminar">
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
            
            

        </table>
        </div>
        

        
        
        <div class="w-1/2 mx-auto p-5">
            {{ $alumnos->appends(request()->query())->links('Comp.pagination') }}
        </div>


    
@endsection
