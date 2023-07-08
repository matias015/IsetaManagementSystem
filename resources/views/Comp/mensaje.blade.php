@if (Session::get('mensaje'))
    <div class="toast px-2 py-1 gap-4 fixed flex rounded right-1 top-1 bg-green-200 ">
            <p class="">{{ Session::get('mensaje') }}</p>
            <span class="close">&times;</span>
    </div>
@endif
@if (Session::get('error'))
<div class="toast px-2 py-1 gap-4 fixed flex rounded right-1 top-1 bg-red-200 ">
    <p class="">{{ Session::get('error') }}</p>
    <span class="close">&times;</span>
</div>
@endif


@if ($errors->any())
  <div class="toast px-2 py-1 gap-4 fixed flex rounded right-1 top-1 bg-red-200 ">
    @foreach ($errors->all() as $error)
      <p class="">{{$error}}</p>
    @endforeach
    <span class="close">&times;</span>
  </div>
    
@endif

<script>
    const toast = document.querySelector('.toast');
const closeBtn = document.querySelector('.close');

closeBtn.addEventListener('click', function() {
  hideToast();
});

// Mostrar el tost
showToast();

// Ocultar el tost después de 3 segundos
setTimeout(function() {
  hideToast();
}, 5000);

function showToast() {
  toast.style.display = 'flex';
}

function hideToast() {
  toast.style.display = 'none';
}
</script>