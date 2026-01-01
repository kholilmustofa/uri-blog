<x-layout :title="$title">
    @push('style')
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
            rel="stylesheet" />
    @endpush

    <!-- Hero Section -->
    <section class="mb-12 border-b border-gray-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
            <div class="flex flex-col lg:flex-row gap-8 justify-between items-end">
                <div class="flex flex-col gap-4 max-w-2xl">
                    <span class="text-indigo-600 font-bold text-sm tracking-widest uppercase block">Our Blog</span>
                    <h1 class="text-[#111813] text-5xl lg:text-6xl font-black leading-tight tracking-tight">
                        Explore our <span class="text-indigo-600">latest stories</span>
                    </h1>
                    <p class="text-gray-500 text-xl font-normal leading-relaxed">
                        Discover insights, tutorials, and news from the team. Stay updated with the tech world.
                    </p>
                </div>
                <div class="w-full lg:max-w-md">
                    <form action="/posts" method="GET" class="relative group">
                        @if (request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if (request('author'))
                            <input type="hidden" name="author" value="{{ request('author') }}">
                        @endif
                        <span
                            class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 material-symbols-outlined group-focus-within:text-indigo-600 transition-colors">search</span>
                        <input name="search" value="{{ request('search') }}"
                            class="w-full h-14 rounded-2xl bg-gray-50 border-transparent focus:border-indigo-600 focus:bg-white focus:ring-4 focus:ring-indigo-100 pl-12 pr-4 text-[#111813] placeholder-gray-400 text-lg transition-all shadow-inner outline-none"
                            placeholder="Search articles..." type="text" />
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content & Sidebar Container -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pb-24">

        <!-- Active Filters -->
        @if (request('category') || request('author') || request('search'))
            <div class="mb-10 flex flex-wrap gap-3 items-center">
                <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">Active Filters:</span>

                @if (request('search'))
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-700 rounded-xl text-sm font-semibold border border-indigo-100">
                        Search: "{{ request('search') }}"
                        <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}"
                            class="hover:text-indigo-900 transition-colors">
                            <span class="material-symbols-outlined text-lg">close</span>
                        </a>
                    </span>
                @endif

                @if (request('category'))
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-700 rounded-xl text-sm font-semibold border border-indigo-100">
                        Category: {{ $categories->firstWhere('slug', request('category'))->name ?? 'Unknown' }}
                        <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}"
                            class="hover:text-indigo-900 transition-colors">
                            <span class="material-symbols-outlined text-lg">close</span>
                        </a>
                    </span>
                @endif

                @if (request('author'))
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-700 rounded-xl text-sm font-semibold border border-indigo-100">
                        Author: {{ request('author') }}
                        <a href="{{ request()->fullUrlWithQuery(['author' => null]) }}"
                            class="hover:text-indigo-900 transition-colors">
                            <span class="material-symbols-outlined text-lg">close</span>
                        </a>
                    </span>
                @endif

                <a href="/posts"
                    class="text-sm text-gray-500 hover:text-indigo-600 font-bold underline decoration-2 underline-offset-4">Clear
                    All</a>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-12 items-start">

            <!-- Blog Posts Grid Area -->
            <div class="w-full lg:w-2/3 xl:w-3/4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-16">
                    @forelse ($posts as $post)
                        <article
                            class="group flex flex-col bg-white rounded-[2.5rem] shadow-sm hover:shadow-2xl hover:shadow-gray-200 transition-all duration-500 border border-gray-100 overflow-hidden h-full">

                            <!-- Image Container -->
                            <div class="relative overflow-hidden aspect-[16/10]">
                                <img src="{{ Str::startsWith($post->image, 'http') ? $post->image : asset('storage/' . $post->image) }}"
                                    alt="{{ $post->title }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                                </div>
                            </div>

                            <!-- Post Content -->
                            <div class="flex flex-col flex-1 p-8 gap-5">
                                <div class="flex items-center justify-between">
                                    <a href="/posts?category={{ $post->category->slug }}"
                                        class="{{ $post->category->color }} bg-opacity-10 px-4 py-1.5 rounded-full text-xs font-bold {{ str_replace('bg-', 'text-', $post->category->color) }} hover:bg-opacity-100 hover:text-white transition-all transform hover:scale-105 active:scale-95">
                                        {{ $post->category->name }}
                                    </a>
                                    <div
                                        class="flex items-center gap-3 text-xs font-bold text-gray-400 uppercase tracking-widest">
                                        <time
                                            datetime="{{ $post->created_at->toIso8601String() }}">{{ $post->created_at->format('M d, Y') }}</time>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <img class="w-8 h-8 rounded-full object-cover border border-gray-100 shadow-sm"
                                        src="{{ $post->author->avatar ? asset('storage/' . $post->author->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name) . '&color=7F9CF5&background=EBF4FF' }}"
                                        alt="{{ $post->author->name }}">
                                    <div class="flex flex-col">
                                        <a href="/posts?author={{ $post->author->username }}"
                                            class="text-xs font-black text-gray-900 hover:text-indigo-600 transition-colors uppercase tracking-widest">{{ $post->author->name }}</a>
                                    </div>
                                </div>

                                <h3
                                    class="text-2xl font-black text-gray-900 leading-tight group-hover:text-indigo-600 transition-colors">
                                    <a href="/posts/{{ $post->slug }}">{{ $post->title }}</a>
                                </h3>

                                <p class="text-gray-500 text-base leading-relaxed flex-1 line-clamp-3">
                                    {!! Str::limit(strip_tags($post->body), 150) !!}
                                </p>

                                <div class="mt-4 pt-6 border-t border-gray-50">
                                    <a class="inline-flex items-center text-sm font-black text-gray-900 group-hover:text-indigo-600 transition-all gap-2"
                                        href="/posts/{{ $post->slug }}">
                                        Read Full Article
                                        <span
                                            class="material-symbols-outlined text-lg group-hover:translate-x-2 transition-transform">arrow_forward</span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div
                            class="col-span-full py-20 text-center bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                            <span class="material-symbols-outlined text-6xl text-gray-300 mb-4 block">search_off</span>
                            <h3 class="text-2xl font-bold text-gray-900">No stories found</h3>
                            <p class="text-gray-500 mt-2">Adjust your filters or search keywords and try again.</p>
                            <a href="/posts"
                                class="mt-8 inline-block px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition-all shadow-lg hover:shadow-indigo-100">Clear
                                all filters</a>
                        </div>
                    @endforelse
                </div>

                <!-- Custom Pagination -->
                @if ($posts->hasPages())
                    <div class="mt-16">
                        {{ $posts->links('posts-pagination') }}
                    </div>
                @endif
            </div>

            <!-- Right Sidebar -->
            <aside class="w-full lg:w-1/3 xl:w-1/4 flex flex-col gap-10 sticky top-24">

                <!-- Categories Widget -->
                <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                    <h4 class="text-lg font-black text-gray-900 mb-6 flex items-center gap-3">
                        <span class="material-symbols-outlined text-indigo-600">category</span> Categories
                    </h4>
                    <ul class="flex flex-col gap-2">
                        @foreach ($categories as $category)
                            <li>
                                <a class="flex items-center justify-between p-3 rounded-2xl hover:bg-gray-50 group transition-all {{ request('category') === $category->slug ? 'bg-indigo-50' : '' }}"
                                    href="/posts?category={{ $category->slug }}">
                                    <span
                                        class="text-gray-600 font-bold group-hover:text-indigo-600 transition-colors {{ request('category') === $category->slug ? 'text-indigo-600' : '' }}">
                                        {{ $category->name }}
                                    </span>
                                    <span
                                        class="bg-gray-100 text-gray-500 text-xs font-black px-3 py-1 rounded-full group-hover:{{ $category->color }} group-hover:text-white transition-all">
                                        {{ $category->posts_count }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Newsletter Widget -->
                <div
                    class="bg-indigo-600 rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-indigo-100">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="relative z-10">
                        <h4 class="text-xl font-black mb-3">Newsletter</h4>
                        <p class="text-indigo-100 text-sm mb-6 leading-relaxed">Get the latest stories and insights
                            delivered straight to your inbox.</p>
                        <form class="flex flex-col gap-3">
                            <input
                                class="w-full h-12 rounded-xl border-none bg-white/10 px-4 text-sm focus:ring-4 focus:ring-white/20 focus:bg-white/20 placeholder-indigo-200 text-white transition-all"
                                placeholder="Your email address" type="email" />
                            <button
                                class="w-full h-12 rounded-xl bg-white text-indigo-600 text-sm font-black hover:bg-indigo-50 transition-all active:scale-95 transform">Subscribe
                                Now</button>
                        </form>
                    </div>
                </div>

            </aside>
        </div>
    </div>
</x-layout>
