@if ($paginator->hasPages())
    <nav class="pagination" aria-label="Paginering">
        <p class="pagination-info">
            Toont {{ $paginator->firstItem() ?? 0 }}–{{ $paginator->lastItem() ?? 0 }} van {{ $paginator->total() }} records
        </p>
        <ul class="pagination-list">
            @if ($paginator->onFirstPage())
                <li><span class="pagination-link disabled">&laquo; Vorige</span></li>
            @else
                <li><a class="pagination-link" href="{{ $paginator->previousPageUrl() }}">&laquo; Vorige</a></li>
            @endif

            @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                <li>
                    @if ($page == $paginator->currentPage())
                        <span class="pagination-link active">{{ $page }}</span>
                    @else
                        <a class="pagination-link" href="{{ $url }}">{{ $page }}</a>
                    @endif
                </li>
            @endforeach

            @if ($paginator->hasMorePages())
                <li><a class="pagination-link" href="{{ $paginator->nextPageUrl() }}">Volgende &raquo;</a></li>
            @else
                <li><span class="pagination-link disabled">Volgende &raquo;</span></li>
            @endif
        </ul>
    </nav>
@endif
