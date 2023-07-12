const carreraSelect = document.querySelector('#carrera_select')
const asignaturaSelect = document.querySelector('#asignatura_select')

carreraSelect.addEventListener('change',function(){
    asignaturaSelect.innerHTML = '';

    fetch(`http://127.0.0.1:8000/api/a/${carreraSelect.value}`)
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