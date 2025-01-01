@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex gap-2 items-center">
        <div>
            @if ($paginator->onFirstPage())
                <x-secondary-button disabled>
                    Предыдущая
                </x-secondary-button>
            @else
                <x-link href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center">
                    <x-primary-button>
                        Предыдущая
                    </x-primary-button>
                </x-link>
            @endif
        </div>

        <div>
            @if ($paginator->hasMorePages())
                <x-link href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center">
                    <x-primary-button>
                        Следующая
                    </x-primary-button>
                </x-link>
            @else
                <x-secondary-button disabled>
                    Следующая
                </x-secondary-button>
            @endif
        </div>

        <div>
            <span class="text-sm text-gray-700">
                {{ $paginator->currentPage() }} из {{ $paginator->lastPage() }}
            </span>
        </div>
    </nav>
@endif
