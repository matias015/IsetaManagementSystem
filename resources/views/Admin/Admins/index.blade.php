@extends('Admin.template')

@section('content')

        {{-- @foreach ($alumnos->pagr as )
            
        @endforeach
        <li class="page-item{{ $page == $alumnos->currentPage() ? ' active' : '' }}">
            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
        </li> --}}

        <div class="perfil_one br">
            <div class="perfil__header">
                <h2>Crear nuevo administrador</h2>
            </div>
            <div class="perfil__info">
            <form method="POST" action="{{route('admin.admins.store')}}">
                @csrf
                <div class="perfil_dataname">
                    <label>Usuario:</label>
                    <input class="campo_info rounded" name="username">
                </div>
                <div class="perfil_dataname">
                    <label>Contraseña:</label>
                    <input class="campo_info rounded" name="password">
                </div>
                <div class="upd"><input type="submit" value="Crear" class="btn_borrar"></div>
            </form>
            </div>
        </div>
        
        <div class="table br">
            <table class="table__body">
                <thead>
                    <tr>
                        <th class="center">Id</th>
                        <th>Usuario</th>
                        <th class="center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $admin)
                    <tr>
                        <td class="center">{{$admin->id}}</td>
                        <td>{{$admin->username}}</td>
                        {{---<td><a href="{{route('admin.admins.edit', ['admin' => $admin->id])}}"><button class="btn_edit">Editar</button></a></td>---}}
                        <td class="center">
                            <form method="POST" action="{{route('admin.admins.destroy', ['admin' => $admin->id])}}">
                                @csrf
                                @method('delete')
                                <input type="submit" value="Eliminar" class="btn_borrar-alt">
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
