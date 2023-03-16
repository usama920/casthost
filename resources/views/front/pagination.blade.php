@php
    // prx($elements);
@endphp
@if ($paginator->hasPages())
    <div class="col">
        <div id="photographyPagination">
            <ul>
                @if ($paginator->onFirstPage())
                    <li class="prev"><a class="btn btn-quaternary disable active"><i
                                class="fas fa-long-arrow-alt-left"></i>Prev</a></li>
                @else
                    <li class="prev"><a class="btn btn-quaternary" href="{{ $paginator->previousPageUrl() }}"
                            title="Prev"><i class="fas fa-long-arrow-alt-left"></i>Prev</a></li>
                @endif
                @foreach ($elements as $element)
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li><a class="btn btn-quaternary disable active"
                                        title="{{ $page }}">{{ $page }}</a></li>
                            @else
                                <li><a class="btn btn-quaternary" href="{{ $url }}"
                                        title="{{ $page }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @else
                        <li><a class="btn btn-quaternary" href="#">{{ $element }}</a></li>
                    @endif
                @endforeach
                @if ($paginator->hasMorePages())
                    <li class="next"><a class="btn btn-quaternary " href="{{ $paginator->nextPageUrl() }}"
                            title="Next">Next<i class="fas fa-long-arrow-alt-right"></i></a></li>
                @else
                    <li class="next"><a class="btn btn-quaternary"><i
                                class="fas fa-long-arrow-alt-right"></i></a></li>
                @endif
            </ul>
        </div>
    </div>
@endif
