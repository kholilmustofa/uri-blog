@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}"
        class="flex items-center justify-center space-x-6">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span
                class="flex items-center justify-center w-12 h-12 rounded-2xl bg-slate-50 text-slate-300 cursor-not-allowed border border-slate-100 opacity-50">
                <span class="material-symbols-outlined text-xl">chevron_left</span>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                class="flex items-center justify-center w-12 h-12 rounded-2xl bg-white text-[#0f172a] border border-slate-200 hover:border-indigo-600 hover:text-indigo-600 hover:shadow-lg hover:shadow-indigo-100 transition-all active:scale-95 group">
                <span
                    class="material-symbols-outlined text-xl group-hover:-translate-x-0.5 transition-transform">chevron_left</span>
            </a>
        @endif

        {{-- Page Info (2 Numbers) --}}
        <div class="flex items-center gap-3">
            <span
                class="flex items-center justify-center w-12 h-12 rounded-2xl bg-indigo-600 text-white font-black shadow-lg shadow-indigo-100">
                {{ $paginator->currentPage() }}
            </span>
            <span class="text-slate-300 font-bold text-lg">/</span>
            <a href="{{ $paginator->url($paginator->lastPage()) }}"
                class="flex items-center justify-center w-12 h-12 rounded-2xl bg-white text-slate-400 border border-slate-100 hover:border-indigo-600 hover:text-indigo-600 transition-all font-bold">
                {{ $paginator->lastPage() }}
            </a>
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                class="flex items-center justify-center w-12 h-12 rounded-2xl bg-white text-[#0f172a] border border-slate-200 hover:border-indigo-600 hover:text-indigo-600 hover:shadow-lg hover:shadow-indigo-100 transition-all active:scale-95 group">
                <span
                    class="material-symbols-outlined text-xl group-hover:translate-x-0.5 transition-transform">chevron_right</span>
            </a>
        @else
            <span
                class="flex items-center justify-center w-12 h-12 rounded-2xl bg-slate-50 text-slate-300 cursor-not-allowed border border-slate-100 opacity-50">
                <span class="material-symbols-outlined text-xl">chevron_right</span>
            </span>
        @endif
    </nav>
@endif
