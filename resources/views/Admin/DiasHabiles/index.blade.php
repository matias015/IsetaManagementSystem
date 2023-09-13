@extends('Admin.template')

@section('content')
    <div class="perfil_one table">
        <h1>Días habiles</h1>
            <form method="POST" action="{{route('admin.habiles.store')}}">
                @csrf
                    <input name="fecha" type="date">
                    <div class="upd"><button class="btn_edit">Agregar</button></div>
            </form>
            <ul>
                @foreach ($habiles as $habil)
                <li>{{$habil->fecha}}</li>

                    <form method="post" action="{{route('admin.habiles.destroy', ['habil' => $habil->id])}}">
                        @method('delete')
                        @csrf
                        <div class="upd"><button class="btn_edit">Eliminar</button></div>
                    </form>
                @endforeach
            </ul>
    </div>
@endsection
