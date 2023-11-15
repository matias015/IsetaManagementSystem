
console.log(2313);

const forms = _findAll('.form-eliminar')
const confirmacion = _find('.confirmacion-popup')
const buttonConfirm = _find('#confirm-button')
const buttonCancel = _find('#cancel-button')

let ACTUAL_FORM = null;

for(form of forms){
    if(form){
        form.addEventListener('submit', function(e){
            e.preventDefault()
            confirmacion.classList.remove('none')
            ACTUAL_FORM = e.target
        })
    }
}

buttonConfirm.addEventListener('click',function(){
    ACTUAL_FORM.submit()
    confirmacion.classList.add('none')
})

buttonCancel.addEventListener('click',function(){
    confirmacion.classList.add('none')
})