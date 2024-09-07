<link rel="stylesheet" href="/css/paginate.css">

@if ($paginator->hasPages())
<div class="pagination__wrap">
    <div class="pagination">
        <ul class="pagination__nav" role="navigation">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="pagination__list"  aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="pagination__item">
                        ‹ 前へ
                    </span>
                </li>
            @else
                <li class="pagination__list">
                    <a class="pagination__item" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        ‹ 前へ
                    </a>
                </li>
            @endif

            

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="pagination__list">
                    <a class="pagination__item" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        次へ ›
                    </a>
                </li>
            @else
                <li class="pagination__list" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="pagination__item">
                        次へ ›
                    </span>
                </li>
            @endif
        </ul>
    </div>
</div>
@endif