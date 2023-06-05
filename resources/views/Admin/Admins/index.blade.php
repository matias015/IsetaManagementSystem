@extends('Admin.template')

@section('content')

    <div>
        

    
            <a href="{{route('admin.admins.create')}}"><button>Agregar admin</button></a>

        <div>
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
        

        <table>
            <tr>
                <td>Id</td>
                <td>Usuario</td>
                <td>Acciones</td>
            </tr>

            <div style="margin:1em">
                <form method="POST" action="{{route('admin.admins.store')}}">
                    @csrf
                    <p>Usuario</p><input name="username">
                    <p>Contraseña</p><input name="password">
                    <p><input type="submit" value="Crear"></p>
                </form>
            </div>

            @foreach ($admins as $admin)
            <tr>
                <td>{{$admin->id}}</td>
                <td>{{$admin->username}}</td>
                <td><a href="{{route('admin.admins.edit', ['admin' => $admin->id])}}"><button>editar</button></a></td>
                <td>
                    <form method="POST" action="{{route('admin.admins.destroy', ['admin' => $admin->id])}}">
                        @csrf
                        @method('delete')
                        <input type="submit" value="Eliminar">
                    </form>
                </td>
            </tr>
            @endforeach

        </table>
        
        <div class="w-1/2 mx-auto p-5">
            {{ $admins->appends(request()->query())->links() }}
        </div>

    </div>
    
@endsection