const boton = _find('#mostrar-btn')
const input = _find('#pw-input')

boton.when('click', () => {
    input.propToggle('type','password','text')

    if(input.attrIs('type','text')) boton.setText('ocultar')
    if(input.attrIs('type','password')) boton.setText('mostrar')
})
