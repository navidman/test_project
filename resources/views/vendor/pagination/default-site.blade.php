@if ($paginator->hasPages())
    <nav class="num-fa">
        <div class="pagination-number center">
            {{-- Previous Page Link --}}
            <div class="arrow-page">
                @if ($paginator->onFirstPage())
                    <span class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span aria-hidden="true">
                        <svg width="9" height="16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="m1.425 14.6 5.433-5.433a1.655 1.655 0 0 0 0-2.334L1.425 1.4" stroke="#BFBFBF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </span>
                @else
                    <span>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        <svg width="9" height="16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="m1.425 14.6 5.433-5.433a1.655 1.655 0 0 0 0-2.334L1.425 1.4" stroke="#BFBFBF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </span>
                @endif
            </div>

            <div class="number">
                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span class="disabled" aria-disabled="true"><span>{{ $element }}</span></span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="active" aria-current="page"><span>{{ $page }}</span></span>
                            @else
                                <span><a href="{{ $url }}">{{ $page }}</a></span>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Next Page Link --}}
            <div class="arrow-page">
                @if ($paginator->hasMorePages())
                    <span>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        <svg width="9" height="16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.575 14.6 2.142 9.167a1.655 1.655 0 0 1 0-2.334L7.575 1.4" stroke="#BFBFBF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </span>
                @else
                    <span class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span aria-hidden="true">
                        <svg width="9" height="16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.575 14.6 2.142 9.167a1.655 1.655 0 0 1 0-2.334L7.575 1.4" stroke="#BFBFBF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </span>
                @endif
            </div>
        </div>
    </nav>
@endif
