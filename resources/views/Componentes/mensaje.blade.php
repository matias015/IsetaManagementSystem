@if (Session::get('mensaje'))
  <div class="z-index-top flex.col left-1 bottom-1 fixed">
    @if (is_array(Session::get('mensaje')))
        @foreach (Session::get('mensaje') as $msj)
          <div class=" toast px-3 py-2 gap-2 my-1 flex just-between rounded bg-green-400 shadow-md">
            <span class="">{{$msj}}</span>
            <span class="close pointer">&times;</span>
          </div>
        @endforeach
    @else
      <div class="z-index-top toast px-3 py-2 gap-2 fixed flex rounded left-1 bottom-1 bg-green-400 shadow-md">
              <p class="">{{ Session::get('mensaje') }}</p>
              <span class="close">&times;</span>
      </div>
    @endif
  </div>
@endif

@if (Session::get('error'))
<div class="z-index-top toast px-2 py-1 gap-2 fixed flex rounded left-1 bottom-1 bg-red-400 shadow-md">
    <p class="">{{ Session::get('error') }}</p>
    <span class="pointer close">&times;</span>
</div>
@endif

@if ($errors->any())
  <div class="z-index-top toast px-2 py-1 gap-2 fixed flex rounded left-1 bottom-1 bg-red-400 shadow-md">
    <div class="flex-col">
    @foreach ($errors->all() as $error)
      <p class="">{{$error}}</p>
    @endforeach
  </div>
    <span class="pointer close">&times;</span>
  </div>
    
@endif
