<x-layout :title="$title">
    @push('style')
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
            rel="stylesheet" />
    @endpush

    <!-- Hero Section -->
    <section class="py-16 md:py-24 bg-white overflow-hidden">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div class="flex flex-col gap-8 order-2 md:order-1">
                    <div>
                        <span class="text-indigo-600 font-bold tracking-widest uppercase text-sm block mb-4">Our
                            Story</span>
                        <h1
                            class="text-5xl md:text-6xl lg:text-7xl font-black text-gray-900 leading-[1.1] tracking-tight">
                            More than just a <br><span class="text-indigo-600">tech blog.</span>
                        </h1>
                    </div>
                    <p class="text-xl text-gray-600 leading-relaxed max-w-md">
                        Uriblog is a place for curious minds to explore technology, lifestyle, and design through
                        in-depth stories and community discussions.
                    </p>
                    <div class="pt-4">
                        <a href="#philosophy"
                            class="inline-flex h-14 px-8 items-center justify-center rounded-xl bg-indigo-600 text-white font-bold text-lg hover:bg-indigo-700 transition-all shadow-lg hover:shadow-indigo-200 active:scale-95 transform">
                            Read Our Philosophy
                        </a>
                    </div>
                </div>
                <div class="order-1 md:order-2 relative">
                    <div class="absolute -inset-4 bg-indigo-100 rounded-3xl blur-2xl opacity-50 -z-10"></div>
                    <div class="aspect-[4/3] w-full bg-gray-100 rounded-2xl overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?q=80&w=2070&auto=format&fit=crop"
                            alt="Modern minimalist workspace"
                            class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-700">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Statement -->
    <section id="philosophy" class="bg-indigo-50 py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center flex flex-col gap-8">
                <div
                    class="mx-auto w-16 h-16 rounded-2xl bg-indigo-600 flex items-center justify-center text-white shadow-xl shadow-indigo-100 mb-4">
                    <span class="material-symbols-outlined text-3xl">lightbulb</span>
                </div>
                <h2 class="text-4xl font-bold text-gray-900">Our Mission</h2>
                <p class="text-2xl md:text-3xl font-medium leading-relaxed text-gray-800 italic">
                    "We believe in sharing knowledge freely and creating a community of learners. Our goal is to provide
                    high-quality insights into the world of tech and design, stripped of jargon and accessible to
                    everyone."
                </p>
            </div>
        </div>
    </section>

    <!-- Values Grid -->
    <section class="py-24 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div
                    class="flex flex-col items-center p-10 bg-gray-50 rounded-3xl text-center group hover:bg-white hover:shadow-2xl hover:shadow-gray-200 transition-all duration-300">
                    <div
                        class="w-16 h-16 rounded-2xl bg-white flex items-center justify-center text-indigo-600 shadow-sm mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-3xl">edit_note</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Quality Content</h3>
                    <p class="text-gray-600 leading-relaxed">Curated articles that focus on substance over clickbait,
                        ensuring every read is valuable.</p>
                </div>
                <div
                    class="flex flex-col items-center p-10 bg-gray-50 rounded-3xl text-center group hover:bg-white hover:shadow-2xl hover:shadow-gray-200 transition-all duration-300">
                    <div
                        class="w-16 h-16 rounded-2xl bg-white flex items-center justify-center text-indigo-600 shadow-sm mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-3xl">groups</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Community First</h3>
                    <p class="text-gray-600 leading-relaxed">A thriving space for discussion, meaningful feedback, and
                        collective growth.</p>
                </div>
                <div
                    class="flex flex-col items-center p-10 bg-gray-50 rounded-3xl text-center group hover:bg-white hover:shadow-2xl hover:shadow-gray-200 transition-all duration-300">
                    <div
                        class="w-16 h-16 rounded-2xl bg-white flex items-center justify-center text-indigo-600 shadow-sm mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-3xl">public</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Global Perspective</h3>
                    <p class="text-gray-600 leading-relaxed">Diverse stories and insights from creative minds and
                        developers around the world.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Author Section -->
    <section class="py-24 bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div
                class="max-w-5xl mx-auto bg-white border border-gray-100 shadow-2xl rounded-3xl overflow-hidden flex flex-col md:flex-row">
                <div class="w-full md:w-2/5 h-80 md:h-auto overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=1974&auto=format&fit=crop"
                        alt="Uri Green - Editor" class="w-full h-full object-cover">
                </div>
                <div class="flex-1 p-10 md:p-16 flex flex-col justify-center">
                    <span class="text-indigo-600 font-bold text-sm tracking-widest uppercase mb-4">Meet the
                        Editor</span>
                    <h3 class="text-4xl font-bold text-gray-900 mb-6">Uri Green</h3>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Hello! I'm Uri, a digital nomad and tech enthusiast. I started Uriblog as a small personal
                        journal to document my coding journey. Today, it has grown into a platform where I share
                        everything I learn about web development, UI design, and living a balanced digital life.
                    </p>
                    <div class="flex gap-6">
                        <a class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all"
                            href="#">
                            <span class="material-symbols-outlined text-2xl">mail</span>
                        </a>
                        <a class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all"
                            href="#">
                            <span class="material-symbols-outlined text-2xl">language</span>
                        </a>
                        <a class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all"
                            href="#">
                            <span class="material-symbols-outlined text-2xl">rss_feed</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter CTA -->
    <section class="py-24 bg-indigo-600">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-4xl md:text-5xl font-black text-white mb-6">Stay in the loop</h2>
                <p class="text-xl text-indigo-100 mb-10 leading-relaxed max-w-2xl mx-auto">
                    Join our newsletter to get the latest stories, tutorials, and insights delivered straight to your
                    inbox.
                    No spam, ever.
                </p>
                <form class="flex flex-col sm:flex-row gap-4 max-w-2xl mx-auto">
                    <input
                        class="flex-1 h-16 px-6 rounded-2xl border-none bg-white/10 text-white placeholder-indigo-200 focus:ring-4 focus:ring-white/20 focus:bg-white/20 transition-all text-lg"
                        placeholder="Enter your email address" type="email">
                    <button
                        class="h-16 px-10 bg-white text-indigo-600 font-bold rounded-2xl hover:bg-indigo-50 transition-all shadow-xl text-lg active:scale-95 transform"
                        type="button">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
    </section>
</x-layout>
