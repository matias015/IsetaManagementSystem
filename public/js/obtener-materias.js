const carreraSelect = document.querySelector('#carrera_select')
const asignaturaSelect = document.querySelector('#asignatura_select')

carreraSelect.addEventListener('change',function(){
    asignaturaSelect.innerHTML = '';
    if(carreraSelect.value=='any') return
    fetch(`/api/a/${carreraSelect.value}`)
        .then( data => data.json())
        .then(data=>{
            data.forEach(element => {
                const option = document.createElement('option')

                option.value = element.id
                option.textContent = element.nombre
                
                asignaturaSelect.appendChild(option)
            });
            
        }).catch(e=>console.log(e))
})