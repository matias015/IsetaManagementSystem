@extends('Admin.template')

@section('content')
    <div>
        <div class="perfil_one br">
            <div class="perfil__header">
                <h2>Crear nueva carrera</h2>
            </div>
            <div class="perfil__info">
                <form method="post" action="{{route('admin.carreras.store')}}">
                @csrf
                    <div class="perfil_dataname">
                        <label>Carrera:</label>
                        <input class="campo_info rounded" name="nombre">
                    </div>
                    <div class="perfil_dataname">
                        <label>Resolucion:</label>
                        <input class="campo_info rounded" name="resolucion">
                    </div>
                    <div class="perfil_dataname">
                        <label>Año apertura:</label>
                        <input class="campo_info rounded" name="anio_apertura">
                    </div>
                    <div class="perfil_dataname">
                        <label>Año fin:</label>
                        <input class="campo_info rounded" name="anio_fin">
                    </div>
                    <div class="perfil_dataname">
                        <label>Observaciones:</label>
                        <input class="campo_info rounded" name="observaciones">
                    </div>

                    <div class="upd"><button class="btn_blue"><i class="ti ti-circle-plus"></i>Crear</button></div>
                </form>
            </div>
        </div>
    </div>
@endsection
