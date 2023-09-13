@extends('Admin.template')

@section('content')

    <div>
        <a href="{{route('admin.admins.create')}}"><button>Agregar admin</button></a>
        
            <form action="{{route('admin.admins.index')}}">
                <p>filtrar</p> 
                 <input value="{{$filtro}}" name="filtro" type="text">
                 <input type="submit" value="Buscar">
            </form>
            <a href="{{route('admin.admins.index')}}"><button>Quitar filtro</button></a>
    </div>

        

        {{-- @foreach ($alumnos->pagr as )
            
        @endforeach
        <li class="page-item{{ $page == $alumnos->currentPage() ? ' active' : '' }}">
            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
        </li> --}}

        <div class="perfil_one" style="margin:1em">
            <form method="POST" action="{{route('admin.admins.store')}}">
                @csrf
                <span class="perfil_dataname">Usuario:<input class="campo_info" name="username"></span>
                <span class="perfil_dataname">Contraseña:<input class="campo_info" name="password"></span>
                <div class="upd"><input type="submit" value="Crear" class="btn_borrar"></div>
            </form>
        </div>
        
        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Usuario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $admin)
                    <tr>
                        <td>{{$admin->id}}</td>
                        <td>{{$admin->username}}</td>
                        <td><a href="{{route('admin.admins.edit', ['admin' => $admin->id])}}"><button class="btn_edit">Editar</button></a></td>
                        <td>
                            <form method="POST" action="{{route('admin.admins.destroy', ['admin' => $admin->id])}}">
                                @csrf
                                @method('delete')
                                <div class="upd"><input type="submit" value="Eliminar" class="btn_borrar"></div>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="w-1/2 mx-auto p-5">
            {{ $admins->appends(request()->query())->links() }}
        </div>

        
    
@endsection
