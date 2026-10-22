@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi halaman" class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        {{-- Mobile --}}
        <div class="flex items-center justify-between gap-2 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center gap-1.5 rounded-xl border border-[#E8EDF5] bg-white px-3.5 py-2 text-xs font-semibold text-[#CBD5E1]">
                    Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                   class="inline-flex items-center gap-1.5 rounded-xl border border-[#E8EDF5] bg-white px-3.5 py-2 text-xs font-semibold text-[#475569] transition hover:border-[#2F6FED]/30 hover:text-[#2F6FED]">
                    Sebelumnya
                </a>
            @endif

            <span class="text-[11px] font-medium text-[#94A3B8]">Hal. {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}</span>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                   class="inline-flex items-center gap-1.5 rounded-xl border border-[#E8EDF5] bg-white px-3.5 py-2 text-xs font-semibold text-[#475569] transition hover:border-[#2F6FED]/30 hover:text-[#2F6FED]">
                    Berikutnya
                </a>
            @else
                <span class="inline-flex items-center gap-1.5 rounded-xl border border-[#E8EDF5] bg-white px-3.5 py-2 text-xs font-semibold text-[#CBD5E1]">
                    Berikutnya
                </span>
            @endif
        </div>

        {{-- Desktop --}}
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <p class="text-[11.5px] text-[#94A3B8]">
                Menampilkan
                @if ($paginator->firstItem())
                    <span class="font-semibold text-[#475569]">{{ $paginator->firstItem() }}</span>–<span class="font-semibold text-[#475569]">{{ $paginator->lastItem() }}</span>
                @else
                    <span class="font-semibold text-[#475569]">0</span>
                @endif
                dari <span class="font-semibold text-[#475569]">{{ $paginator->total() }}</span> data
            </p>

            <div class="flex items-center gap-1">
                {{-- Prev --}}
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true" aria-label="Sebelumnya"
                          class="flex h-8 w-8 items-center justify-center rounded-lg border border-[#E8EDF5] bg-white text-[#CBD5E1]">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" aria-hidden="true"><path d="m15 6-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Sebelumnya"
                       class="flex h-8 w-8 items-center justify-center rounded-lg border border-[#E8EDF5] bg-white text-[#64748B] transition hover:border-[#2F6FED]/30 hover:text-[#2F6FED]">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" aria-hidden="true"><path d="m15 6-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                @endif

                {{-- Pages --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="flex h-8 w-8 items-center justify-center text-[11px] font-semibold text-[#94A3B8]">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page"
                                      class="flex h-8 min-w-8 items-center justify-center rounded-lg bg-[#2F6FED] px-2 text-[11.5px] font-bold text-white shadow-sm shadow-[#2F6FED]/25">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" aria-label="Ke halaman {{ $page }}"
                                   class="flex h-8 min-w-8 items-center justify-center rounded-lg border border-transparent px-2 text-[11.5px] font-semibold text-[#64748B] transition hover:border-[#E8EDF5] hover:bg-white hover:text-[#2F6FED]">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Berikutnya"
                       class="flex h-8 w-8 items-center justify-center rounded-lg border border-[#E8EDF5] bg-white text-[#64748B] transition hover:border-[#2F6FED]/30 hover:text-[#2F6FED]">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" aria-hidden="true"><path d="m9 6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                @else
                    <span aria-disabled="true" aria-label="Berikutnya"
                          class="flex h-8 w-8 items-center justify-center rounded-lg border border-[#E8EDF5] bg-white text-[#CBD5E1]">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" aria-hidden="true"><path d="m9 6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </span>
                @endif
            </div>
        </div>
    </nav>
@endif
