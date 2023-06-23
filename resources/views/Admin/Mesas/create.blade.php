@extends('Admin.template')

@section('content')
    <div>
        @if ($errors -> any())
            @foreach ($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif

        <select name="carrera" id="carrera">
            @foreach ($carreras as $carrera)
                <option value="{{$carrera->id}}">{{$carrera->nombre}}</option>
            @endforeach
        </select>

       <form method="post" action="{{route('admin.mesas.store')}}">
        @csrf

        <p>
            materia 
            <select class="asignatura" name="id_asignatura">
                <option value="">selecciona una carrera</option>
            </select>
        </p>
        <p>
            Profesor 
            <select class="profesor" name="prof_presidente">
                <option selected value="vacio">vacio/A confirmar</option>
                @foreach ($profesores as $profesor)
                    <option value="{{$profesor->id}}">{{$profesor->nombre.' '.$profesor->apellido}}</option>
                @endforeach
            </select>
        </p>
        <p>
            Profesor 1
            <select class="profesor" name="prof_vocal_1">
                <option selected value="vacio">vacio/A confirmar</option>
                @foreach ($profesores as $profesor)
                    <option value="{{$profesor->id}}">{{$profesor->nombre.' '.$profesor->apellido}}</option>
                @endforeach
            </select>
        </p>
        <p>
            Profesor 2
            <select class="profesor" name="prof_vocal_2">
                <option selected value="vacio">vacio/A confirmar</option>
                @foreach ($profesores as $profesor)
                    <option value="{{$profesor->id}}">{{$profesor->nombre.' '.$profesor->apellido}}</option>
                @endforeach
            </select>
        </p>

        <p>
            Llamado
            <select name="llamado">
                <option value="1">Primero</option>
                <option value="2">Segundo</option>
            </select>
        </p>

        <p>
            Fecha
            <input type="datetime-local" name="fecha">
        </p>


        <input type="submit" value="Crear">
       </form>
    </div>

    <script>
        const carrera = document.querySelector('#carrera')
        const asignaturaSelect = document.querySelector('.asignatura')
        carrera.addEventListener('change',function(){
            asignaturaSelect.innerHTML = '';
            fetch(`http://127.0.0.1:8000/api/a/${carrera.value}`)
                .then( data => data.json())
                .then(data=>{
                    data.forEach(element => {
                        const option = document.createElement('option')
                        option.value = element.id
                        option.textContent = element.nombre
                        asignaturaSelect.appendChild(option)
                    });
                    
                })
        })
    </script>
@endsection