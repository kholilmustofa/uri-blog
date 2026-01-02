<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('categories.index') }}"
                    class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center hover:bg-slate-200 transition-all">
                    <span class="material-symbols-outlined text-[#0f172a]">arrow_back</span>
                </a>
                <div>
                    <h2 class="text-3xl font-black text-[#0f172a] tracking-tight">
                        {{ $category->name }}
                    </h2>
                    <p class="text-sm text-slate-500 font-bold">{{ $category->posts_count }} posts in this category</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('categories.edit', $category) }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all hover:-translate-y-0.5 shadow-lg shadow-indigo-100">
                    <span class="material-symbols-outlined text-xl">edit</span>
                    Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Category Info Card -->
            <div class="bg-white overflow-hidden shadow-sm rounded-[2.5rem] border border-slate-100 mb-8">
                <div class="p-8">
                    <div class="flex items-center gap-6">
                        <div class="w-20 h-20 rounded-2xl flex items-center justify-center"
                            style="background-color: {{ $category->color }}20">
                            <span class="material-symbols-outlined text-4xl"
                                style="color: {{ $category->color }}">label</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-black text-[#0f172a] mb-1">{{ $category->name }}</h3>
                            <p class="text-slate-500 font-bold mb-3">Slug: {{ $category->slug }}</p>
                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-lg" style="background-color: {{ $category->color }}">
                                    </div>
                                    <span class="text-sm font-bold text-slate-600">{{ $category->color }}</span>
                                </div>
                                <span class="text-slate-300">•</span>
                                <span class="text-sm font-bold text-slate-600">{{ $category->posts_count }}
                                    posts</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Posts in this Category -->
            @if ($posts->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm rounded-[2.5rem] border border-slate-100">
                    <div class="p-8">
                        <h3 class="text-2xl font-black text-[#0f172a] mb-6">Posts in {{ $category->name }}</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($posts as $post)
                                <article
                                    class="group bg-white border-2 border-slate-100 rounded-2xl overflow-hidden hover:border-indigo-600 hover:shadow-xl hover:shadow-indigo-50 transition-all">
                                    @if ($post->image)
                                        <div class="aspect-video bg-slate-100 overflow-hidden">
                                            <img src="{{ asset('storage/' . $post->image) }}"
                                                alt="{{ $post->title }}"
                                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        </div>
                                    @endif
                                    <div class="p-6">
                                        <div class="flex items-center gap-2 mb-3">
                                            <span class="text-xs font-black text-slate-400 uppercase tracking-wider">
                                                {{ $post->created_at->format('M d, Y') }}
                                            </span>
                                        </div>
                                        <h3
                                            class="text-lg font-black text-[#0f172a] mb-2 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                            {{ $post->title }}
                                        </h3>
                                        <p class="text-sm text-slate-500 font-bold mb-4 line-clamp-2">
                                            {{ Str::limit(strip_tags($post->body), 100) }}
                                        </p>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <img src="{{ $post->author->avatar ? asset('storage/' . $post->author->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name) . '&background=EEF2FF&color=4F46E5' }}"
                                                    alt="{{ $post->author->name }}"
                                                    class="w-8 h-8 rounded-full object-cover border-2 border-white">
                                                <span
                                                    class="text-xs font-bold text-slate-600">{{ $post->author->name }}</span>
                                            </div>
                                            <a href="{{ url('/posts/' . $post->slug) }}"
                                                class="text-sm font-bold text-indigo-600 hover:text-indigo-700">
                                                Read →
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if ($posts->hasPages())
                            <div class="mt-8">
                                {{ $posts->links('posts-pagination') }}
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm rounded-[2.5rem] border border-slate-100">
                    <div class="p-16 text-center">
                        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <span class="material-symbols-outlined text-5xl text-slate-300">article</span>
                        </div>
                        <h3 class="text-2xl font-black text-[#0f172a] mb-2">No Posts Yet</h3>
                        <p class="text-slate-500 font-bold mb-6">This category doesn't have any posts yet.</p>
                        <a href="{{ url('/dashboard/create') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all hover:-translate-y-0.5 shadow-lg shadow-indigo-100">
                            <span class="material-symbols-outlined text-xl">add</span>
                            Create Post
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
