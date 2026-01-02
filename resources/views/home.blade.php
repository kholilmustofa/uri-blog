<x-layout :title="$title">
    @push('style')
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
            rel="stylesheet" />
        <style>
            :root {
                --primary: #4f46e5;
                --primary-hover: #4338ca;
            }
        </style>
    @endpush

    <div class="bg-[#f8fafc]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex flex-col gap-20">
            <!-- Hero Section -->
            <section class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center py-16 lg:py-24">
                <!-- Content -->
                <div class="flex flex-col gap-8 order-2 lg:order-1">
                    <div class="flex flex-col gap-6">
                        <h1
                            class="text-5xl md:text-6xl lg:text-7xl font-black leading-[1.1] tracking-tight text-[#0f172a]">
                            Explore the Unseen World of Ideas.
                        </h1>
                        <p class="text-xl text-[#64748b] leading-relaxed max-w-xl">
                            Uriblog is your daily source for tech trends, lifestyle hacks, and creative writing. Dive
                            into stories that matter.
                        </p>
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="/posts"
                            class="flex items-center justify-center rounded-2xl h-14 px-10 bg-[#4f46e5] text-white text-lg font-black hover:bg-[#4338ca] transition-all hover:-translate-y-1 shadow-xl shadow-indigo-200">
                            Start Reading
                        </a>
                        <a href="/about"
                            class="flex items-center justify-center rounded-2xl h-14 px-10 bg-transparent border-2 border-slate-200 text-[#0f172a] text-lg font-bold hover:bg-white hover:border-slate-300 transition-all">
                            Learn More
                        </a>
                    </div>
                </div>
                <!-- Image -->
                <div class="order-1 lg:order-2">
                    <div class="relative group">
                        <div
                            class="absolute -inset-4 bg-indigo-500/10 rounded-[2.5rem] blur-2xl group-hover:bg-indigo-500/20 transition-all duration-500">
                        </div>
                        <div class="relative aspect-[4/3] rounded-[2rem] overflow-hidden shadow-2xl">
                            <img src="https://images.unsplash.com/photo-1499951360447-b19be8fe80f5?q=80&w=1200&auto=format&fit=crop"
                                alt="Hero Workspace"
                                class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                        </div>
                    </div>
                </div>
            </section>

            <!-- Blog Grid Section -->
            <section class="flex flex-col gap-10">
                <div class="flex items-center justify-between border-b border-slate-100 pb-6">
                    <h2 class="text-3xl font-black text-[#0f172a] tracking-tight">Fresh from the Press</h2>
                    <a href="/posts"
                        class="flex items-center gap-2 text-lg font-black text-[#4f46e5] hover:text-[#4338ca] transition-colors group">
                        View All
                        <span
                            class="material-symbols-outlined transform group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    @forelse ($featuredPosts as $post)
                        <article class="flex flex-col gap-6 group">
                            <div class="relative aspect-video rounded-3xl overflow-hidden bg-slate-100 shadow-sm">
                                <img src="{{ Str::startsWith($post->image, 'http') ? $post->image : asset('storage/' . $post->image) }}"
                                    alt="{{ $post->title }}"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <a href="/posts?category={{ $post->category->slug }}"
                                    class="absolute top-5 left-5 backdrop-blur-md px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest shadow-sm hover:opacity-90 transition-all"
                                    style="background-color: {{ $post->category->color }}E6; color: white">
                                    {{ $post->category->name }}
                                </a>
                            </div>
                            <div class="flex flex-col gap-4">
                                <h3
                                    class="text-2xl font-black text-[#0f172a] leading-tight group-hover:text-[#4f46e5] transition-colors">
                                    <a href="/posts/{{ $post->slug }}">{{ $post->title }}</a>
                                </h3>
                                <p class="text-[#64748b] text-base leading-relaxed line-clamp-2">
                                    {!! Str::limit(strip_tags($post->body), 120) !!}
                                </p>
                                <div class="flex items-center gap-4 mt-2">
                                    <img class="w-10 h-10 rounded-full object-cover border-2 border-slate-100"
                                        src="{{ $post->author->avatar ? asset('storage/' . $post->author->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name) . '&color=4f46e5&background=EEF2FF' }}"
                                        alt="{{ $post->author->name }}">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black text-[#0f172a]">{{ $post->author->name }}</span>
                                        <span class="text-[10px] font-bold text-[#64748b] uppercase tracking-widest">
                                            {{ $post->created_at->format('M d, Y') }} · 5 min read
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div
                            class="col-span-full py-20 text-center bg-white rounded-[2.5rem] border-2 border-dashed border-slate-100">
                            <span class="material-symbols-outlined text-6xl text-slate-200 mb-4">article</span>
                            <h3 class="text-xl font-bold text-slate-400">No stories found.</h3>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- Newsletter Section -->
            <section class="mb-20">
                <div
                    class="bg-white border border-slate-100 rounded-[3rem] p-12 md:p-20 flex flex-col items-center text-center gap-8 shadow-sm relative overflow-hidden">
                    <div class="absolute -top-20 -right-20 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl"></div>

                    <div class="max-w-2xl flex flex-col gap-4 relative z-10">
                        <div
                            class="w-16 h-16 rounded-full bg-indigo-50 flex items-center justify-center mx-auto mb-2 text-indigo-600">
                            <span class="material-symbols-outlined text-3xl">mail</span>
                        </div>
                        <h2 class="text-4xl md:text-5xl font-black text-[#0f172a]">Stay Updated</h2>
                        <p class="text-[#64748b] text-lg max-w-xl mx-auto">
                            Join our weekly newsletter. No spam, just stories, insights and updates from the team.
                        </p>
                    </div>

                    <form class="w-full max-w-md flex flex-col sm:flex-row gap-4 relative z-10">
                        <input type="email" placeholder="Enter your email address"
                            class="flex-1 h-16 px-8 rounded-2xl bg-[#f8fafc] border-none text-lg text-[#0f172a] placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 transition-all">
                        <button
                            class="h-16 px-10 bg-[#4f46e5] hover:bg-[#4338ca] text-white font-black rounded-2xl transition-all shadow-xl shadow-indigo-100 whitespace-nowrap text-lg active:scale-95">
                            Subscribe
                        </button>
                    </form>

                    <p class="text-xs text-[#64748b] font-medium">
                        We care about your data in our <a href="#" class="underline hover:text-indigo-600">privacy
                            policy</a>.
                    </p>
                </div>
            </section>
            </main>
        </div>
</x-layout>
