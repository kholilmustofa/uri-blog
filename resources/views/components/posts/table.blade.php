@if (Session::has('success'))
    <div class="fixed top-24 left-1/2 -translate-x-1/2 z-[60] animate-in slide-in-from-top duration-300">
        <div id="toast-success"
            class="flex items-center gap-3 w-full max-w-sm p-4 bg-white rounded-2xl shadow-2xl border border-slate-100"
            role="alert">
            <div
                class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-indigo-50 text-indigo-600 rounded-xl">
                <span class="material-symbols-outlined">check_circle</span>
            </div>
            <div class="text-sm font-black text-[#0f172a]">{{ Session::get('success') }}</div>
            <button type="button"
                class="ms-auto p-1.5 text-slate-400 hover:text-[#0f172a] hover:bg-slate-50 rounded-lg transition-all"
                data-dismiss-target="#toast-success" aria-label="Close">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>
    </div>
@endif

<!-- Start block -->
<section class="antialiased">
    <div class="flex flex-col md:flex-row items-center justify-between gap-6 p-8 border-b border-slate-50">
        <div class="w-full md:w-1/2">
            <form class="relative group" action="" method="GET">
                <div class="absolute inset-y-0 left-0 flex items-center pl-5 pointer-events-none">
                    <span
                        class="material-symbols-outlined text-slate-400 group-focus-within:text-indigo-600 transition-colors">search</span>
                </div>
                <input type="text" id="simple-search" name="keyword"
                    class="w-full h-14 pl-14 pr-6 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 text-sm text-[#0f172a] placeholder-slate-400 font-bold transition-all outline-none"
                    placeholder="Search through your stories..." value="{{ request('keyword') }}">
            </form>
        </div>
        <div class="w-full md:w-auto flex flex-col md:flex-row gap-4 shrink-0">
            <a href="/dashboard/create"
                class="flex items-center justify-center h-14 px-8 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl shadow-xl shadow-indigo-100 transform active:scale-95 transition-all gap-2 uppercase tracking-widest text-xs">
                <span class="material-symbols-outlined text-xl">add</span>
                Write New Story
            </a>
        </div>
    </div>

    <div class="overflow-x-auto px-4 pb-4">
        <table class="w-full text-sm text-left">
            <thead>
                <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                    <th scope="col" class="px-6 py-8">No.</th>
                    <th scope="col" class="px-6 py-8">Article Details</th>
                    <th scope="col" class="px-6 py-8 text-center">Category</th>
                    <th scope="col" class="px-6 py-8">Timeline</th>
                    <th scope="col" class="px-6 py-8 text-right">Settings</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse ($posts as $post)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-6 font-black text-slate-300 text-xs">{{ $posts->firstItem() + $loop->index }}
                        </td>
                        <td class="px-6 py-6 max-w-md">
                            <div class="flex flex-col gap-1">
                                <a href="/dashboard/{{ $post->slug }}"
                                    class="text-base font-black text-[#0f172a] hover:text-indigo-600 transition-colors line-clamp-1">
                                    {{ $post->title }}
                                </a>
                                <p class="text-xs text-slate-400 font-medium line-clamp-1">
                                    {{ Str::limit(strip_tags($post->body), 80) }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-6 text-center">
                            <span
                                class="{{ $post->category->color }} text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest bg-opacity-10">
                                {{ $post->category->name }}
                            </span>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex flex-col gap-0.5">
                                <span
                                    class="text-xs font-black text-[#0f172a]">{{ $post->created_at->format('M d, Y') }}</span>
                                <span
                                    class="text-[10px] text-slate-400 font-bold">{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-6 text-right" x-data="{ showModal: false }">
                            <div class="flex items-center justify-end gap-2">
                                <a href="/dashboard/{{ $post->slug }}/edit"
                                    class="p-3 bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 hover:border-indigo-600 rounded-xl transition-all shadow-sm">
                                    <span class="material-symbols-outlined text-xl">edit</span>
                                </a>
                                <button type="button" @click="showModal = true"
                                    class="p-3 bg-white border border-slate-100 text-slate-400 hover:text-red-600 hover:border-red-600 rounded-xl transition-all shadow-sm">
                                    <span class="material-symbols-outlined text-xl">delete</span>
                                </button>
                            </div>

                            <!-- Delete confirm modal -->
                            <template x-teleport="body">
                                <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                    class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                                    style="display: none;">

                                    <div @click.away="showModal = false" x-show="showModal"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                        x-transition:leave="transition ease-in duration-200"
                                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                                        class="relative bg-white rounded-[2.5rem] shadow-2xl p-8 md:p-12 text-center flex flex-col items-center gap-8 border border-slate-50 w-full max-w-md">

                                        <div
                                            class="w-24 h-24 bg-red-50 text-red-600 rounded-[2rem] flex items-center justify-center shadow-inner">
                                            <span class="material-symbols-outlined text-5xl">delete_forever</span>
                                        </div>

                                        <div class="flex flex-col gap-3">
                                            <h3 class="text-3xl font-black text-[#0f172a] tracking-tight">Delete Story?
                                            </h3>
                                            <p class="text-slate-500 font-bold leading-relaxed">
                                                Are you sure you want to delete <span
                                                    class="text-indigo-600">"{{ $post->title }}"</span>? This action
                                                cannot be undone.
                                            </p>
                                        </div>

                                        <div class="flex flex-col sm:flex-row gap-4 w-full">
                                            <button @click="showModal = false" type="button"
                                                class="flex-1 h-16 bg-slate-50 text-[#0f172a] font-black rounded-2xl hover:bg-slate-100 transition-all uppercase tracking-widest text-xs">
                                                Keep it
                                            </button>
                                            <form action="/dashboard/{{ $post->slug }}" method="post"
                                                class="flex-1">
                                                @method('delete')
                                                @csrf
                                                <button type="submit"
                                                    class="w-full h-16 bg-red-600 text-white font-black rounded-2xl hover:bg-red-700 shadow-xl shadow-red-100 transition-all uppercase tracking-widest text-xs flex items-center justify-center gap-2">
                                                    Delete Now
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </td>
                    @empty
                    <tr>
                        <td colspan="5" class="py-24 text-center">
                            <div class="flex flex-col items-center gap-4 text-slate-300">
                                <span class="material-symbols-outlined text-7xl">draft</span>
                                <p class="text-lg font-black tracking-tight text-slate-400">No stories found</p>
                                <a href="/dashboard/create"
                                    class="text-indigo-600 font-black uppercase tracking-widest text-xs hover:underline">Start
                                    writing now</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($posts->hasPages())
        <div class="px-8 py-8 border-t border-slate-50 bg-slate-50/50">
            {{ $posts->links('posts-pagination') }}
        </div>
    @endif
</section>
