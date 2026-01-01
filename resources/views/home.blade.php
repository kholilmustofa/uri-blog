<x-layout :title="$title">
    @push('style')
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
            rel="stylesheet" />
    @endpush

    <!-- Modern Hero Section -->
    <section class="relative bg-white pt-20 pb-32 overflow-hidden">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-4xl mx-auto flex flex-col gap-8">
                <div>
                    <span
                        class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50 text-indigo-600 text-sm font-bold tracking-wide mb-6">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-600"></span>
                        </span>
                        New stories updated weekly
                    </span>
                    <h1 class="text-6xl md:text-7xl lg:text-8xl font-black text-gray-900 leading-[1.05] tracking-tight">
                        Insights for the <br><span class="text-indigo-600">Modern Developer.</span>
                    </h1>
                </div>
                <p class="text-xl md:text-2xl text-gray-500 leading-relaxed max-w-2xl mx-auto">
                    Uri Blog is your destination for deep dives into web development, design systems, and the future of
                    technology.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                    <a href="/posts"
                        class="w-full sm:w-auto px-10 h-16 flex items-center justify-center bg-indigo-600 text-white font-bold rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:-translate-y-1 transition-all active:scale-95 text-lg">
                        Explore Articles
                    </a>
                    <a href="/about"
                        class="w-full sm:w-auto px-10 h-16 flex items-center justify-center bg-white text-gray-900 font-bold rounded-2xl border border-gray-200 hover:bg-gray-50 hover:border-gray-300 transition-all text-lg">
                        Our Story
                    </a>
                </div>
            </div>
        </div>
        <!-- Abstract Background Decoration -->
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-indigo-50 rounded-full blur-3xl opacity-50"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-indigo-50 rounded-full blur-3xl opacity-50"></div>
    </section>

    <!-- Stats Dashboard -->
    <section class="bg-gray-50/50 py-12 border-y border-gray-100">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="flex flex-col items-center text-center p-6 bg-white rounded-3xl border border-gray-100 shadow-sm">
                    <span
                        class="material-symbols-outlined text-4xl text-indigo-600 mb-4 bg-indigo-50 p-4 rounded-2xl">article</span>
                    <div class="text-3xl font-black text-gray-900 mb-1">{{ number_format($stats['posts']) }}</div>
                    <div class="text-gray-500 font-bold text-sm uppercase tracking-widest">Articles Published</div>
                </div>
                <div
                    class="flex flex-col items-center text-center p-6 bg-white rounded-3xl border border-gray-100 shadow-sm">
                    <span
                        class="material-symbols-outlined text-4xl text-indigo-600 mb-4 bg-indigo-50 p-4 rounded-2xl">group</span>
                    <div class="text-3xl font-black text-gray-900 mb-1">{{ number_format($stats['authors']) }}</div>
                    <div class="text-gray-500 font-bold text-sm uppercase tracking-widest">Expert Authors</div>
                </div>
                <div
                    class="flex flex-col items-center text-center p-6 bg-white rounded-3xl border border-gray-100 shadow-sm">
                    <span
                        class="material-symbols-outlined text-4xl text-indigo-600 mb-4 bg-indigo-50 p-4 rounded-2xl">category</span>
                    <div class="text-3xl font-black text-gray-900 mb-1">{{ number_format($stats['categories']) }}</div>
                    <div class="text-gray-500 font-bold text-sm uppercase tracking-widest">Active Categories</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Stories Section -->
    <section class="py-24 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16">
                <div class="max-w-2xl">
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tight leading-tight mb-4">
                        Latest <span class="text-indigo-600">Stories</span>
                    </h2>
                    <p class="text-xl text-gray-500 leading-relaxed">
                        The very latest insights and tutorials from our creative community. No fluff, just value.
                    </p>
                </div>
                <a href="/posts"
                    class="inline-flex items-center gap-3 text-indigo-600 font-black text-lg hover:gap-5 transition-all group">
                    View all stories
                    <span class="material-symbols-outlined transition-transform">arrow_forward</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse ($featuredPosts as $post)
                    <article
                        class="group flex flex-col bg-white rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:shadow-gray-200 transition-all duration-500 h-full overflow-hidden">

                        <!-- Image Container -->
                        <div class="relative overflow-hidden aspect-[16/10]">
                            <img src="{{ Str::startsWith($post->image, 'http') ? $post->image : asset('storage/' . $post->image) }}"
                                alt="{{ $post->title }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="flex flex-col flex-1 p-8 gap-6 relative z-10">
                            <!-- Category Badge -->
                            <div>
                                <a href="/posts?category={{ $post->category->slug }}"
                                    class="inline-block {{ $post->category->color }} bg-opacity-10 px-4 py-1.5 rounded-full text-xs font-bold {{ str_replace('bg-', 'text-', $post->category->color) }} hover:bg-opacity-100 hover:text-white transition-all transform hover:scale-110 active:scale-95">
                                    {{ $post->category->name }}
                                </a>
                            </div>

                            <!-- Title -->
                            <h3
                                class="text-2xl font-black text-gray-900 leading-tight group-hover:text-indigo-600 transition-colors">
                                <a href="/posts/{{ $post->slug }}">{{ $post->title }}</a>
                            </h3>

                            <!-- Excerpt -->
                            <p class="text-gray-500 text-base leading-relaxed flex-1 line-clamp-3">
                                {!! Str::limit(strip_tags($post->body), 120) !!}
                            </p>

                            <!-- Footer -->
                            <div class="mt-4 pt-6 border-t border-gray-50 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img class="w-10 h-10 rounded-full object-cover border border-gray-100"
                                        src="{{ $post->author->avatar ? asset('storage/' . $post->author->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name) . '&color=7F9CF5&background=EBF4FF' }}"
                                        alt="{{ $post->author->name }}">
                                    <div class="flex flex-col">
                                        <a href="/posts?author={{ $post->author->username }}"
                                            class="text-xs font-black text-gray-900 hover:text-indigo-600 transition-colors uppercase tracking-widest">{{ $post->author->name }}</a>
                                        <time
                                            class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $post->created_at->format('M d, Y') }}</time>
                                    </div>
                                </div>
                                <a href="/posts/{{ $post->slug }}"
                                    class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 text-gray-400 group-hover:bg-indigo-600 group-hover:text-white transition-all transform group-hover:rotate-12">
                                    <span class="material-symbols-outlined text-xl">north_east</span>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div
                        class="col-span-full py-20 text-center bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                        <span class="material-symbols-outlined text-6xl text-gray-300 mb-4 block">article</span>
                        <h3 class="text-2xl font-bold text-gray-900">No stories available yet</h3>
                        <p class="text-gray-500 mt-2">Come back later for new insights.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Newsletter CTA on Home -->
    <section class="pb-24 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div
                class="bg-indigo-600 rounded-[3rem] p-12 md:p-20 text-center relative overflow-hidden shadow-2xl shadow-indigo-200">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/50 to-transparent"></div>
                <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>

                <div class="relative z-10 max-w-2xl mx-auto flex flex-col gap-8">
                    <h2 class="text-4xl md:text-6xl font-black text-white leading-tight">Join the community of curious
                        minds.</h2>
                    <p class="text-xl text-indigo-100 opacity-90">Subscribe to our newsletter and get weekly insights on
                        development and design.</p>
                    <form class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto w-full">
                        <input
                            class="flex-1 h-16 px-6 rounded-2xl bg-white/10 border-none text-white placeholder-indigo-200 focus:ring-4 focus:ring-white/20 focus:bg-white/20 transition-all text-lg"
                            placeholder="Enter your email address" type="email">
                        <button
                            class="h-16 px-10 bg-white text-indigo-600 font-black rounded-2xl hover:bg-indigo-50 transition-all shadow-xl active:scale-95 transform whitespace-nowrap text-lg">
                            Get Early Access
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-layout>
