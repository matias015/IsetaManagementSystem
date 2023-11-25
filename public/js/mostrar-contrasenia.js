const boton = _find('#mostrar-btn')
const input = _find('#pw-input')

boton.when('click', () => input.propToggle('type','password','text'))
