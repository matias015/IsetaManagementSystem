// const toast = document.querySelector('.toast');
const closeBtn = document.querySelector('.close');

if(closeBtn){
  window.addEventListener('click', clickHideToast);

  // Ocultar el tost después de 3 segundos
  setTimeout(function() {
    _findAll('.toast').forEach(element => { 
      hideToast(element);
    })
    window.removeEventListener('click', clickHideToast)
  }, 7000);


  function clickHideToast(e){
    console.log(3);
      if(e.target.classList.contains('close')){
        hideToast(_parent(e.target));
      }
    }
  }

  function hideToast(toast) {
    toast.style.display = 'none';
  }
