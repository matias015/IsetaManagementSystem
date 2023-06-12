@extends('Admin.template')

@section('content')
    <div>
        @if ($errors -> any())
            @foreach ($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif


       <form method="post" action="{{route('admin.examenes.store')}}">
        @csrf

       <select id="alumno" name="alumno">
            <option value="1">Mendez</option>
            <option value="2">Sanchez</option>
       </select>
       <table>
            <tr>
                <td>Materia</td>
                <td>Dia</td>
                <td>Llamado</td>
            </tr>
            
       </table>
       <select id="mesa" name="mesa">
            <option value="1">Matematicas</option>
            <option value="2">Algebra</option>
        </select>

        <input type="submit" value="Inscribir">
       </form>
    </div>
    <script>
        const alumnos = document.querySelector('#alumno')
        const mesas = document.querySelector('#mesa')
        alumnos.addEventListener('change',function(){
            mesas.innerHTML = '';
            fetch(`http://127.0.0.1:8000/api/a/${alumnos.value}`)
                .then( data => data.json())
                .then(data=>{
                    /**
                     * <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
                     * */
                    data.forEach(element => {
                        const tr = document.createElement('tr')
                        const tr = document.createElement('td')
                        option.textContent = element.id
                        option.textContent = element.nombre
                        mesas.appendChild(option)
                    });
                    
                })
        })
    </script>
@endsection