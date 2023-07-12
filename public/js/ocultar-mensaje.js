 const toast = document.querySelector('.toast');
const closeBtn = document.querySelector('.close');

  if(closeBtn){
    closeBtn.addEventListener('click', function() {
      hideToast();
    });



    // Ocultar el tost después de 3 segundos
    setTimeout(function() {
      hideToast();
    }, 5000);


    function hideToast() {
      toast.style.display = 'none';
    }
  }