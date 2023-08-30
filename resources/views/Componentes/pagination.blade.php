<link rel="stylesheet" href="{{asset('css/Pagination/pagination.css')}}">

@if ($paginator->hasPages())

<ul class="pager">
    @if ($paginator->onFirstPage())
             <li class="disabled btn1"><span><i class="ti ti-square-rounded-chevron-left"></i>Anterior</span></li>
    @else
        <li class="btn1"><a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="ti ti-square-rounded-chevron-left"></i>Anterior</a></li>
    @endif
    @foreach ($elements as $element)
        @if (is_string($element))
            <li class="disabled no-active"><span>{{ $element }}</span></li>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="active my-active"><span>{{ $page }}</span></li>
                @else
                    <li class="no-active"><a href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach
    @if ($paginator->hasMorePages())
        <li class="btn2"><a href="{{ $paginator->nextPageUrl() }}" rel="next">Siguiente<i class="ti ti-square-rounded-chevron-right"></i></a></li>
    @else
        <li class="disabled btn2"><span>Siguiente<i class="ti ti-square-rounded-chevron-right"></i></span></li>
    @endif
</ul>

@endif 
