@extends('Admin.template')

@section('content')

    <div class="contenedor-tabla_botonera">

        <form class="none grid lg-block form-hh" action="{{route('admin.profesores.index')}}">
            <div class="tabla_botonera gap-5 flex items-end">
                
                <div class="contenedor_ordenar">
                    <span class="categoria">Ordenar</span>
                    <div>
                        <select class="ordenar border-none p-1 shadow" name="orden">
                            <option @selected($filtros['orden'] == 'nombre') value="nombre">Nombre</option>
                            <option @selected($filtros['orden'] == 'dni') value="dni">DNI</option>
                            <option @selected($filtros['orden'] == 'dni-desc') value="dni-desc">DNI descendiente</option>

                        </select>
                    </div>
                </div>
                <div class="contenedor_filtrar">
                    <span class="categoria">Mostrar</span> 
                    <div>
                        <select class="filtrar border-none p-1 shadow" name="campo">
                            <option value="ninguno">Ninguno</option>
                            <option @selected($filtros['campo'] == 'registrados') value="registrados">Registrados</option>
                        </select>
                    </div>
                </div>

                <div class="contenedor_filtrado">
                    <input placeholder="Encontrar filtro..." class="filtrado-busqueda border-none p-1 shadow" value="{{$filtros['filtro']}}" name="filtro" type="text">
                </div>
                
                <div class="contenedor_btn-busqueda">
                    <button class="btn_sky"><i class="ti ti-search"></i>Buscar</button>
                </div>
            </div>
        </form>
    
        
    
    <a class="none lg-block" href="{{route('admin.profesores.index')}}"><button class="btn_red"><i class="ti ti-backspace"></i>Quitar filtros</button></a>
    </div>


        {{-- @foreach ($profesores->pagr as )
            
        @endforeach
        <li class="page-item{{ $page == $profesores->currentPage() ? ' active' : '' }}">
            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
        </li> --}}
        
        <div class="table">
            <div class="perfil__header-alt">
                <a href="{{route('admin.profesores.create')}}"><button class="btn_blue"><i class="ti ti-circle-plus"></i>Agregar profesor</button></a>
            </div>
        <table class="table__body">
            <thead>
                <tr>
                    <th>Nombre</td>
                    <th>Apellido</td>
                    <th>DNI</td>
                    <th>Email</th>
                    <th class="center">Acción</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($profesores as $profesor)
                <tr>
                    <td class="capitalize">{{$profesor->nombre}}</td>
                    <td class="capitalize">{{($profesor->apellido)}}</td>
                    <td>{{$profesor->dniPuntos()}}</td>
                    <td>{{$profesor->email?$profesor->email:'Sin mail registrado'}}</td>
                    <td class="flex just-center"><a  href="{{route('admin.profesores.edit', ['profesor' => $profesor->id])}}"><button class="btn_blue"><i class="ti ti-file-info"></i>Detalles</button></a></td>
      
    
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        <div class="w-1/2 mx-auto p-5 pagination">
            {{ $profesores->appends(request()->query())->links('Componentes.pagination') }}
        </div>
  
@endsection
