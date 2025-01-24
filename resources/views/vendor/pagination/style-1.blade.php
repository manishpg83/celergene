<style>
    .pagination.style-1 {
        list-style: none;
        padding: 0;
        display: flex;
        gap: 5px;
    }

    .pagination.style-1 .page-item {
        display: inline;
    }

    .pagination.style-1 .page-link {
        text-decoration: none;
        color: #333;
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        transition: background-color 0.3s, color 0.3s;
    }

    .pagination.style-1 .page-link:hover {
        background-color: #071d13;
        color: #fff;
    }

    .pagination.style-1 .page-item.active .page-link {
        background-color: #071d13;
        color: #fff;
        border-color: #071d13;
    }

    .pagination.style-1 .page-item.disabled .page-link {
        color: #ccc;
        cursor: not-allowed;
    }
</style>

@if ($paginator->hasPages())
    <div class="d-flex justify-content-center">
        <nav aria-label="Table Pagination">
            <ul class="pagination style-1">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">Prew</span>
                    </li>
                @else
                    <li class="page-item">
                        <button class="page-link" wire:click="previousPage" wire:loading.attr="disabled">Prew</button>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item disabled" aria-disabled="true"><span
                                class="page-link">{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <button class="page-link" wire:click="gotoPage({{ $page }})" wire:loading.attr="disabled">
                                        {{ $page }}
                                    </button>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <button class="page-link" wire:click="nextPage" wire:loading.attr="disabled">Next</button>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">Next</span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif

