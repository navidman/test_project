@if ($paginator->hasPages())
    <nav>
        <ul class="pagination-items" style="direction: ltr">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span aria-hidden="true"><svg width="10" height="16" viewBox="0 0 13 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m5.996 12.98-4.59-4.923a1.577 1.577 0 0 1 0-2.114l4.59-4.922" stroke="#C4C4C4" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><svg width="10" height="16" viewBox="0 0 13 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m5.996 12.98-4.59-4.923a1.577 1.577 0 0 1 0-2.114l4.59-4.922" stroke="#C4C4C4" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><svg width="10" height="16" viewBox="0 0 13 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m1.996 12.98 4.59-4.923a1.577 1.577 0 0 0 0-2.114l-4.59-4.922" stroke="#C4C4C4" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                </li>
            @else
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span aria-hidden="true"><svg width="10" height="16" viewBox="0 0 13 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m1.996 12.98 4.59-4.923a1.577 1.577 0 0 0 0-2.114l-4.59-4.922" stroke="#C4C4C4" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                </li>
            @endif
        </ul>
    </nav>
@endif
