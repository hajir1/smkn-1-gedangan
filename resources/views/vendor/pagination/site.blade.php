@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi halaman" class="flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-slate-500">
            Menampilkan <span class="font-semibold text-brand-950">{{ $paginator->firstItem() }}–{{ $paginator->lastItem() }}</span>
            dari <span class="font-semibold text-brand-950">{{ $paginator->total() }}</span>
        </p>
        <ul class="flex items-center gap-1">
            @if ($paginator->onFirstPage())
                <li><span class="grid h-9 w-9 place-content-center rounded-full text-slate-300"><x-icon name="arrow-left" class="h-4 w-4" /></span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="grid h-9 w-9 place-content-center rounded-full text-brand-800 hover:bg-brand-50" aria-label="Sebelumnya"><x-icon name="arrow-left" class="h-4 w-4" /></a></li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span class="px-2 text-slate-400">{{ $element }}</span></li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><span aria-current="page" class="grid h-9 min-w-9 place-content-center rounded-full bg-brand-800 px-3 text-sm font-semibold text-white">{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}" class="grid h-9 min-w-9 place-content-center rounded-full px-3 text-sm font-medium text-slate-600 hover:bg-brand-50 hover:text-brand-800">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" rel="next" class="grid h-9 w-9 place-content-center rounded-full text-brand-800 hover:bg-brand-50" aria-label="Berikutnya"><x-icon name="arrow-right" class="h-4 w-4" /></a></li>
            @else
                <li><span class="grid h-9 w-9 place-content-center rounded-full text-slate-300"><x-icon name="arrow-right" class="h-4 w-4" /></span></li>
            @endif
        </ul>
    </nav>
@endif
