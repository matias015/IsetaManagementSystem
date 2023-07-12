@if (Session::get('mensaje'))
    <div class="z-index-top toast px-3 py-2 gap-2 fixed flex rounded left-1 bottom-1 bg-green-300 soft-shadow-2">
            <p class="">{{ Session::get('mensaje') }}</p>
            <span class="close">&times;</span>
    </div>
@endif
@if (Session::get('error'))
<div class="z-index-top toast px-2 py-1 gap-2 fixed flex rounded left-1 bottom-1 bg-red-300 soft-shadow-2">
    <p class="">{{ Session::get('error') }}</p>
    <span class="close">&times;</span>
</div>
@endif


@if ($errors->any())
  <div class="z-index-top toast px-2 py-1 gap-2 fixed flex rounded left-1 bottom-1 bg-red-300 soft-shadow-2">
    <div class="flex-col">
    @foreach ($errors->all() as $error)
      <p class="">{{$error}}</p>
    @endforeach
  </div>
    <span class="close">&times;</span>
  </div>
    
@endif
