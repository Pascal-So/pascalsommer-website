@if(! isset($from_page_two) || ! $from_page_two || $items->currentPage() > 1)
    @if($items->hasMorePages() || $items->currentPage() != 1)
        <p>
            @if($items->currentPage() > 1)
                <a href="{{ $items->previousPageUrl() }}"><img class="arrow-icon-small" src="{{ asset('img/icons/larrow.svg') }}"></a>
            @else
                <span class="arrow-icon-small-placeholder"></span>
            @endif
            
            {{ $items->currentPage() }}

            @if($items->hasMorePages())
                <a href="{{ $items->nextPageUrl() }}"><img class="arrow-icon-small" src="{{ asset('img/icons/rarrow.svg') }}"></a>
            @else
                <span class="arrow-icon-small-placeholder"></span>
            @endif
        </p>
    @endif
@endif