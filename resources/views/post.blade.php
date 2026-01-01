<x-layout :title="$title">
    @push('style')
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
            rel="stylesheet" />
    @endpush

    <main class="bg-white pt-10 pb-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="mb-10 flex items-center gap-3 text-sm font-bold">
                <a href="/" class="text-gray-400 hover:text-indigo-600 transition-colors">Home</a>
                <span class="material-symbols-outlined text-gray-300 text-sm">chevron_right</span>
                <a href="/posts" class="text-gray-400 hover:text-indigo-600 transition-colors">Blog</a>
                <span class="material-symbols-outlined text-gray-300 text-sm">chevron_right</span>
                <span class="text-indigo-600 truncate max-w-[200px] sm:max-w-none">{{ $post->title }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-16 items-start">

                <!-- Main Article Content -->
                <article class="flex flex-col">

                    <!-- Header Meta -->
                    <div class="flex items-center gap-4 mb-6">
                        <a href="/posts?category={{ $post->category->slug }}"
                            class="{{ $post->category->color }} bg-opacity-10 px-4 py-1.5 rounded-full text-xs font-black {{ str_replace('bg-', 'text-', $post->category->color) }} hover:bg-opacity-100 hover:text-white transition-all transform hover:scale-105">
                            {{ $post->category->name }}
                        </a>
                        <div class="flex items-center gap-2 text-gray-400 text-xs font-bold uppercase tracking-widest">
                            <span class="material-symbols-outlined text-xs">schedule</span>
                            {{ $post->created_at->format('M d, Y') }}
                        </div>
                    </div>

                    <!-- Title -->
                    <h1
                        class="text-4xl md:text-5xl lg:text-6xl font-black text-gray-900 leading-[1.1] tracking-tight mb-8">
                        {{ $post->title }}
                    </h1>

                    <!-- Author Info -->
                    <div class="flex items-center justify-between py-8 border-y border-gray-100 mb-10">
                        <div class="flex items-center gap-4">
                            <img class="w-14 h-14 rounded-full object-cover border-2 border-indigo-50 p-0.5"
                                src="{{ $post->author->avatar ? asset('storage/' . $post->author->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name) . '&color=7F9CF5&background=EBF4FF' }}"
                                alt="{{ $post->author->name }}">
                            <div class="flex flex-col">
                                <a href="/posts?author={{ $post->author->username }}"
                                    class="text-base font-black text-gray-900 hover:text-indigo-600 transition-colors uppercase tracking-widest">{{ $post->author->name }}</a>
                                <span class="text-xs text-gray-400 font-bold uppercase tracking-widest">Article
                                    Author</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <button
                                class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 text-gray-400 hover:bg-indigo-600 hover:text-white transition-all transform hover:scale-110 active:scale-95 shadow-sm">
                                <span class="material-symbols-outlined text-lg">share</span>
                            </button>
                            <button
                                class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 text-gray-400 hover:bg-indigo-600 hover:text-white transition-all transform hover:scale-110 active:scale-95 shadow-sm">
                                <span class="material-symbols-outlined text-lg">bookmark</span>
                            </button>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="mb-12 overflow-hidden rounded-[2.5rem] shadow-2xl shadow-gray-200">
                        <img src="{{ Str::startsWith($post->image, 'http') ? $post->image : asset('storage/' . $post->image) }}"
                            alt="{{ $post->title }}"
                            class="w-full h-auto object-cover max-h-[500px] hover:scale-105 transition-transform duration-700">
                    </div>

                    <!-- Article Body -->
                    <div
                        class="prose prose-xl prose-indigo max-w-none text-gray-600 leading-relaxed prose-headings:font-black prose-headings:text-gray-900 prose-blockquote:border-l-indigo-600 prose-blockquote:bg-indigo-50/50 prose-blockquote:px-8 prose-blockquote:py-4 prose-blockquote:rounded-r-3xl prose-a:text-indigo-600 prose-a:font-bold hover:prose-a:text-indigo-800">
                        {!! $post->body !!}
                    </div>



                </article>

                <!-- Sidebar -->
                <aside class="space-y-10 sticky top-24">

                    <!-- Newsletter Widget -->
                    <div
                        class="bg-indigo-600 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-2xl shadow-indigo-100">
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                        <div class="relative z-10">
                            <h4 class="text-xl font-black mb-3">Stay Updated</h4>
                            <p class="text-indigo-100 text-sm mb-6 leading-relaxed">Join 10k+ developers who get our
                                weekly insights.</p>
                            <form class="flex flex-col gap-3">
                                <input
                                    class="w-full h-12 rounded-xl border-none bg-white/10 px-4 text-sm focus:ring-4 focus:ring-white/20 focus:bg-white/20 placeholder-indigo-200 text-white transition-all"
                                    placeholder="Email address" type="email" />
                                <button
                                    class="w-full h-12 rounded-xl bg-white text-indigo-600 text-sm font-black hover:bg-indigo-50 transition-all active:scale-95 transform">Subscribe</button>
                            </form>
                        </div>
                    </div>

                    <!-- Related Stories -->
                    <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm">
                        <h4 class="text-lg font-black text-gray-900 mb-8 flex items-center justify-between">
                            Related Stories
                            <span class="material-symbols-outlined text-indigo-600">article</span>
                        </h4>
                        <div class="flex flex-col gap-8">
                            @forelse ($relatedPosts as $relatedPost)
                                <a href="/posts/{{ $relatedPost->slug }}" class="group flex flex-col gap-2">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="{{ $relatedPost->category->color }} bg-opacity-10 px-2 py-0.5 rounded-full text-[10px] font-black {{ str_replace('bg-', 'text-', $relatedPost->category->color) }}">
                                            {{ $relatedPost->category->name }}
                                        </span>
                                        <span
                                            class="text-[10px] text-gray-400 font-bold">{{ $relatedPost->created_at->format('M d') }}</span>
                                    </div>
                                    <h5
                                        class="text-sm font-black text-gray-900 leading-tight group-hover:text-indigo-600 transition-colors line-clamp-2">
                                        {{ $relatedPost->title }}
                                    </h5>
                                </a>
                            @empty
                                <p class="text-sm text-gray-400">No related stories found.</p>
                            @endforelse
                        </div>
                        <a href="/posts"
                            class="mt-10 block text-center py-3 rounded-2xl bg-gray-50 text-gray-500 text-xs font-black hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                            View All Blog
                        </a>
                    </div>

                    <!-- Share Widget Sidebar -->
                    <div class="px-8 py-6 border border-gray-100 rounded-[2rem]">
                        <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Share this article
                        </h4>
                        <div class="flex items-center gap-4">
                            <a href="#" class="text-gray-400 hover:text-indigo-600 transition-colors"><span
                                    class="material-symbols-outlined">link</span></a>
                            <a href="#" class="text-gray-400 hover:text-indigo-600 transition-colors"><span
                                    class="material-symbols-outlined">mail</span></a>
                            <a href="#" class="text-gray-400 hover:text-indigo-600 transition-colors"><span
                                    class="material-symbols-outlined">alternate_email</span></a>
                        </div>
                    </div>

                </aside>

            </div>


        </div>
    </main>
</x-layout>
