@extends('Admin.template')

@section('content')
    <div>
        @if ($errors -> any())
            @foreach ($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif

        <select name="carrera" id="carrera">
            <option selected >Selecciona una carrera</option>
            @foreach ($carreras as $carrera)
                <option value="{{$carrera->id}}">{{$carrera->nombre}}</option>
            @endforeach
        </select>

       <form method="post" action="{{route('admin.cursadas.store')}}">
        @csrf

        <p>
            materia 
            <select class="asignatura" name="id_asignatura">
                <option value="">selecciona una carrera</option>
            </select>
        </p>
        <p>
            Alumno 
            <select class="alumno" name="id_alumno">
                <option selected>selecciona un alumno</option>
                @foreach($alumnos as $alumno)
                    <option value="{{$alumno->id}}">{{$alumno->nombre.' '.$alumno->apellido}}</option>
                @endforeach
            </select>
        </p>


        <p>Año de cursada <input placeholder="2023" name="anio_cursada"></p>
        <p>Condicion 
            <select name="condicion">
                <option value="1">Libre</option>
                <option selected value="2">Presencial</option>
                <option value="3">Desertor</option>    
                <option value="4">Atraso acadamico</option>
                <option value="5">Otro</option>
            </select>    
        </p>

        <input type="submit" value="Crear">
       </form>
    </div>

    <script>
        const carrera = document.querySelector('#carrera')
        const asignaturaSelect = document.querySelector('.asignatura')
        const alumnosSelect = document.querySelector('.alumnos')

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
        // asignaturaSelect.addEventListener('change',function(){
        //     alumnosSelect.innerHTML = '';
        //     fetch(`http://127.0.0.1:8000/api/cursadas/alumnos/${asignaturaSelect.value}`)
        //         .then( data => data.json())
        //         .then(data=>{
        //             alert(data)
        //             data.forEach(element => {
        //                 const option = document.createElement('option')
        //                 option.value = element.id
        //                 option.textContent = element.nombre
        //                 alumnosSelect.appendChild(option)
        //             });
                    
        //         })
        // })
    </script>
@endsection