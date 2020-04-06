@if(! isset($from_page_two) || ! $from_page_two || $items->currentPage() > 1)
    @if($items->hasMorePages() || $items->currentPage() != 1)
        <p id={{ $element_id ?? "" }}>
            @if($items->currentPage() > 1)
                <a href="{{ $items->previousPageUrl() }}#start-content" class="inline-block" data-shortcutkeycode="37">
                    <img class="arrow-icon-small" src="{{ asset('img/icons/larrow.svg') }}">
                </a>
            @else
                <span class="arrow-icon-small-placeholder"></span>
            @endif

            {{ $items->currentPage() }} / {{ $items->lastPage() }}

            @if($items->hasMorePages())
                <a href="{{ $items->nextPageUrl() }}#start-content" class="inline-block" data-shortcutkeycode="39">
                    <img class="arrow-icon-small" src="{{ asset('img/icons/rarrow.svg') }}">
                </a>
            @else
                <span class="arrow-icon-small-placeholder"></span>
            @endif
        </p>
    @endif
@endif
