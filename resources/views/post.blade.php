<x-layout :title="$title">
    @push('style')
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
            rel="stylesheet" />
        <style>
            .blog-content a {
                color: #4f46e5;
                font-weight: 700;
                text-decoration: underline;
            }

            .blog-content blockquote {
                border-left-color: #4f46e5;
                background: rgba(79, 70, 229, 0.05);
            }
        </style>
    @endpush

    <main class="bg-white py-12 pb-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="mb-10 flex items-center gap-3 text-sm font-bold">
                <a href="/" class="text-slate-500 hover:text-indigo-600 transition-colors">Home</a>
                <span class="material-symbols-outlined text-slate-300 text-sm">chevron_right</span>
                <a href="/posts" class="text-slate-500 hover:text-indigo-600 transition-colors">Blog</a>
                <span class="material-symbols-outlined text-slate-300 text-sm">chevron_right</span>
                <span class="text-indigo-600 truncate max-w-[200px] sm:max-w-none">{{ $post->title }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-16 items-start">

                <!-- Main Article Content -->
                <article class="flex flex-col">

                    <!-- Header Meta -->
                    <div class="flex items-center gap-4 mb-6">
                        <a href="/posts?category={{ $post->category->slug }}"
                            class="px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest hover:opacity-80 transition-all"
                            style="background-color: {{ $post->category->color }}20; color: {{ $post->category->color }}">
                            {{ $post->category->name }}
                        </a>
                        <div class="flex items-center gap-2 text-slate-500 text-xs font-bold uppercase tracking-widest">
                            <span class="material-symbols-outlined text-xs">schedule</span>
                            {{ $post->created_at->format('M d, Y') }} · 5 min read
                        </div>
                    </div>

                    <!-- Title -->
                    <h1
                        class="text-4xl md:text-5xl lg:text-6xl font-black text-[#0f172a] leading-[1.1] tracking-tight mb-8">
                        {{ $post->title }}
                    </h1>

                    <!-- Author Info -->
                    <div class="flex items-center justify-between py-8 border-y border-slate-100 mb-10">
                        <div class="flex items-center gap-4">
                            <img class="w-14 h-14 rounded-full object-cover border-2 border-indigo-50 p-0.5"
                                src="{{ $post->author->avatar ? asset('storage/' . $post->author->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name) . '&color=4F46E5&background=EEF2FF' }}"
                                alt="{{ $post->author->name }}">
                            <div class="flex flex-col">
                                <a href="/posts?author={{ $post->author->username }}"
                                    class="text-base font-black text-[#0f172a] hover:text-indigo-600 transition-colors uppercase tracking-widest">{{ $post->author->name }}</a>
                                <span class="text-xs text-slate-500 font-bold uppercase tracking-widest">Article
                                    Author</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <button
                                class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-indigo-600 hover:text-white transition-all transform hover:scale-110 active:scale-95 shadow-sm">
                                <span class="material-symbols-outlined text-lg">share</span>
                            </button>
                            <button
                                class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-indigo-600 hover:text-white transition-all transform hover:scale-110 active:scale-95 shadow-sm">
                                <span class="material-symbols-outlined text-lg">bookmark</span>
                            </button>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="mb-12 overflow-hidden rounded-[2.5rem] shadow-2xl shadow-indigo-100/20">
                        <img src="{{ Str::startsWith($post->image, 'http') ? $post->image : asset('storage/' . $post->image) }}"
                            alt="{{ $post->title }}"
                            class="w-full h-auto object-cover max-h-[500px] hover:scale-105 transition-transform duration-700">
                    </div>

                    <!-- Article Body -->
                    <div
                        class="prose prose-xl max-w-none text-[#0f172a] leading-relaxed prose-headings:font-black prose-headings:text-[#0f172a] prose-p:font-medium prose-p:text-slate-600 blog-content">
                        {!! $post->body !!}
                    </div>

                </article>

                <!-- Sidebar -->
                <aside class="space-y-10 sticky top-24">

                    <!-- Newsletter Widget -->
                    <div
                        class="bg-indigo-600 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-xl shadow-indigo-100">
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/20 rounded-full blur-2xl"></div>
                        <div class="relative z-10">
                            <h4 class="text-xl font-black mb-3">Stay Updated</h4>
                            <p class="text-indigo-100 font-bold text-sm mb-6 leading-relaxed">Join 10k+ developers who
                                get our
                                weekly insights.</p>
                            <form class="flex flex-col gap-3">
                                <input
                                    class="w-full h-12 rounded-xl border-none bg-white/20 px-4 text-sm focus:ring-2 focus:ring-white focus:bg-white focus:text-indigo-900 placeholder-indigo-100 text-white transition-all"
                                    placeholder="Email address" type="email" />
                                <button
                                    class="w-full h-12 rounded-xl bg-white text-indigo-600 text-sm font-black hover:bg-indigo-50 transition-all active:scale-95 transform">Subscribe</button>
                            </form>
                        </div>
                    </div>

                    <!-- Related Stories -->
                    <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm">
                        <h4 class="text-lg font-black text-[#0f172a] mb-8 flex items-center justify-between">
                            Related Stories
                            <span class="material-symbols-outlined text-indigo-600">article</span>
                        </h4>
                        <div class="flex flex-col gap-8">
                            @forelse ($relatedPosts as $relatedPost)
                                <a href="/posts/{{ $relatedPost->slug }}" class="group flex flex-col gap-2">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-widest"
                                            style="background-color: {{ $relatedPost->category->color }}20; color: {{ $relatedPost->category->color }}">
                                            {{ $relatedPost->category->name }}
                                        </span>
                                        <span
                                            class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $relatedPost->created_at->format('M d') }}</span>
                                    </div>
                                    <h5
                                        class="text-sm font-black text-[#0f172a] leading-tight group-hover:text-indigo-600 transition-colors line-clamp-2">
                                        {{ $relatedPost->title }}
                                    </h5>
                                </a>
                            @empty
                                <p class="text-sm text-slate-500 font-bold">No related stories found.</p>
                            @endforelse
                        </div>
                        <a href="/posts"
                            class="mt-10 block text-center py-4 rounded-2xl bg-slate-50 text-slate-500 text-xs font-black uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all">
                            View All Blog
                        </a>
                    </div>

                    <!-- Share Widget Sidebar -->
                    <div class="px-8 py-6 border border-slate-100 rounded-[2rem]">
                        <h4 class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4">Share this article
                        </h4>
                        <div class="flex items-center gap-4 text-slate-400">
                            <a href="#" class="hover:text-indigo-600 transition-colors"><span
                                    class="material-symbols-outlined">link</span></a>
                            <a href="#" class="hover:text-indigo-600 transition-colors"><span
                                    class="material-symbols-outlined">mail</span></a>
                            <a href="#" class="hover:text-indigo-600 transition-colors"><span
                                    class="material-symbols-outlined">alternate_email</span></a>
                        </div>
                    </div>

                </aside>

            </div>


        </div>
    </main>
</x-layout>
