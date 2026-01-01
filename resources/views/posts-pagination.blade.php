@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}"
        class="flex items-center justify-center space-x-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span
                class="flex items-center justify-center w-12 h-12 rounded-2xl bg-gray-50 text-gray-300 cursor-not-allowed border border-gray-100 transition-all">
                <span class="material-symbols-outlined">chevron_left</span>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                class="flex items-center justify-center w-12 h-12 rounded-2xl bg-white text-gray-500 border border-gray-200 hover:border-indigo-600 hover:text-indigo-600 hover:shadow-lg hover:shadow-indigo-50 transition-all active:scale-95 group">
                <span
                    class="material-symbols-outlined group-hover:-translate-x-0.5 transition-transform">chevron_left</span>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="flex items-center justify-center w-12 h-12 text-gray-400 font-bold" aria-disabled="true">
                    {{ $element }}
                </span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page"
                            class="flex items-center justify-center w-12 h-12 rounded-2xl bg-indigo-600 text-white font-black shadow-xl shadow-indigo-100 transform scale-110 z-10">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                            class="flex items-center justify-center w-12 h-12 rounded-2xl bg-white text-gray-500 border border-gray-200 hover:border-indigo-600 hover:text-indigo-600 hover:shadow-lg hover:shadow-indigo-50 transition-all font-bold active:scale-95">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                class="flex items-center justify-center w-12 h-12 rounded-2xl bg-white text-gray-500 border border-gray-200 hover:border-indigo-600 hover:text-indigo-600 hover:shadow-lg hover:shadow-indigo-50 transition-all active:scale-95 group">
                <span
                    class="material-symbols-outlined group-hover:translate-x-0.5 transition-transform">chevron_right</span>
            </a>
        @else
            <span
                class="flex items-center justify-center w-12 h-12 rounded-2xl bg-gray-50 text-gray-300 cursor-not-allowed border border-gray-100 transition-all">
                <span class="material-symbols-outlined">chevron_right</span>
            </span>
        @endif
    </nav>
@endif
