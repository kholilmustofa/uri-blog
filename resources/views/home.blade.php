<x-layout :title="$title">
    <section aria-labelledby="welcome-heading">
        <h2 id="welcome-heading" class="sr-only">Welcome Section</h2>
        <p class="text-lg">Welcome to <strong>Uri Blog</strong> - Your source for insightful articles and stories</p>

        <!-- Demo Content -->
        <div class="flex mt-3" role="list" aria-label="Even numbers demonstration">
            @for ($i = 1; $i <= 10; $i++)
                @if ($i % 2 == 0)
                    <div class="w-8 h-8 bg-teal-500 text-white p-0 me-1 text-xs grid place-items-center" role="listitem">
                        {{ $i }}</div>
                @endif
            @endfor
        </div>
    </section>
</x-layout>
