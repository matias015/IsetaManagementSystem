const carreraSelect = _find('#carrera_select')
const asignaturaSelect = _find('#asignatura_select')

carreraSelect.when('change', function(){
    asignaturaSelect.clear()
    if(carreraSelect.valueIs('any')) return
    
    fetch(`/api/a/${carreraSelect.value()}`)
    .then(asig => asig.json())
    .then(asig => {
        asig.forEach(asignatura => {
            asignaturaSelect.createChild('<option>')
                .withText(asignatura.nombre)
                .withAttrs({value: asignatura.id})
            });
            
            asignaturaSelect.insert()
    })
    .catch(e=>console.log(e))
})