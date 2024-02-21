@if ($paginator->hasPages())
<nav class="flex-pagination pagination is-rounded" aria-label="pagination">
    @if ($paginator->onFirstPage())
        <span class="pagination-previous">Précédent</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagination-previous">Précédent</a>
    @endif
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="pagination-next">Suivant</a>
    @else
        <span class="pagination-next disabled">Suivant</span>
    @endif
    <!--
    @if($paginator->currentPage() < $paginator->lastPage() - 2)
        <li class="hidden-xs"><a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
    @endif
    -->
    <ul class="pagination-list">
        @if($paginator->currentPage() > 3)
            <li><a href="{{ $paginator->url(1) }}" class="pagination-link" aria-label="Goto page 1">1</a></li>
        @endif
        @if ($paginator->currentPage() > 4)
            <li><span class="pagination-ellipsis">&hellip;</span></li>
        @endif
        @foreach(range(1, $paginator->lastPage()) as $i)
            @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                @if ($i == $paginator->currentPage())
                        <li><a href="{{ $paginator->url($i) }}" class="pagination-link is-current" aria-label="Aller à la page {{ $i }}"
                               aria-current="page">{{ $i }}</a></li>
                @else
                    <li><a href="{{ $paginator->url($i) }}" class="pagination-link" aria-label="Aller à la page {{ $i }}">{{ $i }}</a></li>
                    <li><a href="{{ $paginator->url($i) }}"></a></li>
                @endif
            @endif
        @endforeach
        @if($paginator->currentPage() < $paginator->lastPage() - 3)
            <li><span class="pagination-ellipsis">&hellip;</span></li>
        @endif
        @if($paginator->currentPage() < $paginator->lastPage() - 2)
            <li><a href="{{ $paginator->url($paginator->lastPage()) }}" class="pagination-link" aria-label="Aller à la page {{ $paginator->lastPage() }}">{{ $paginator->lastPage() }}</a></li>
            <!--<li class="hidden-xs"><a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>-->
        @endif
    </ul>
</nav>
@endif
