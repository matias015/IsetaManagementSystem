
@if (Session::get('error'))
    <div class="alert alert-success">
        {{ Session::get('error') }}
    </div>
@endif
@if (Session::get('mensaje'))
    <div class="alert alert-success">
        {{ Session::get('error') }}
    </div>
@endif