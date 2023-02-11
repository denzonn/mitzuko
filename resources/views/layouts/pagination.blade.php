<nav aria-label="Page navigation example">
    <ul class="pagination">
        <li class="page-item {{ $paginator->currentPage() == 1 ? ' disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" tabindex="-1">Previous</a>
        </li>

        @for ($i = max($paginator->currentPage() - 1, 1); $i <= min($paginator->currentPage() + 1, $paginator->lastPage()); $i++)
            <li class="page-item {{ $paginator->currentPage() == $i ? ' active' : '' }}">
                <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
            </li>
        @endfor

        <li class="page-item {{ $paginator->currentPage() == $paginator->lastPage() ? ' disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}">Next</a>
        </li>
    </ul>
</nav>
