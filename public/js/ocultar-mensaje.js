const botonesCerrar = elements().whereClass('close')

if(botonesCerrar.hasElements()){ 
  
  botonesCerrar.get().forEach(function(boton){
    boton.when('click', function(){
      boton.parent().hide()
    })
  })

  botonesCerrar.get().forEach(function(boton){
      boton.parent().removeAfter(7000, () => boton.unsetEvent('click'))
  })

}