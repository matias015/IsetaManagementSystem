@extends('Admin.template')

@section('content')
    <h1>dias habiles</h1>
    <form method="POST" action="{{route('admin.habiles.store')}}">
        @csrf
        <input name="fecha" type="date">
        <button>Agregar</button>
    </form>
    <ul>
        @foreach ($habiles as $habil)
            <li>{{$habil->fecha}}</li>

            <form method="post" action="{{route('admin.habiles.destroy', ['habil' => $habil->id])}}">
                @method('delete')
                @csrf
                <button>Eliminar</button>
            </form>
        @endforeach
    </ul>
@endsection