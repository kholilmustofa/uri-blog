<x-layout :title="$title">
    @push('style')
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
            rel="stylesheet" />
    @endpush

    <!-- Hero Section -->
    <section class="py-16 md:py-24 bg-white overflow-hidden">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div class="flex flex-col gap-8 order-2 md:order-1 text-[#0f172a]">
                    <div>
                        <span class="text-indigo-600 font-black tracking-widest uppercase text-sm block mb-4">Our
                            Story</span>
                        <h1 class="text-4xl md:text-5xl lg:text-7xl font-black leading-[1.1] tracking-tight">
                            More than just a <br><span class="text-indigo-600">tech blog.</span>
                        </h1>
                    </div>
                    <p class="text-xl text-slate-500 leading-relaxed max-w-md font-medium">
                        Uriblog is a place for curious minds to explore technology, lifestyle, and design through
                        in-depth stories and community discussions.
                    </p>
                    <div class="pt-4">
                        <a href="#philosophy"
                            class="inline-flex h-14 px-8 items-center justify-center rounded-2xl bg-indigo-600 text-white font-black text-lg hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 active:scale-95 transform">
                            Read Our Philosophy
                        </a>
                    </div>
                </div>
                <div class="order-1 md:order-2 relative">
                    <div class="absolute -inset-4 bg-indigo-50 rounded-[2.5rem] blur-2xl opacity-50 -z-10"></div>
                    <div class="aspect-[4/3] w-full bg-slate-100 rounded-[2rem] overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?q=80&w=2070&auto=format&fit=crop"
                            alt="Modern minimalist workspace"
                            class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-700">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Statement -->
    <section id="philosophy" class="bg-[#f8fafc] py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center flex flex-col gap-8">
                <div
                    class="mx-auto w-16 h-16 rounded-2xl bg-indigo-600 flex items-center justify-center text-white shadow-xl shadow-indigo-100 mb-4">
                    <span class="material-symbols-outlined text-3xl">lightbulb</span>
                </div>
                <h2 class="text-4xl font-black text-[#0f172a]">Our Mission</h2>
                <p class="text-2xl md:text-3xl font-bold leading-relaxed text-[#0f172a] italic">
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
                    class="flex flex-col items-center p-10 bg-[#f8fafc] rounded-[2.5rem] text-center group hover:bg-white hover:shadow-2xl hover:shadow-slate-100 transition-all duration-300">
                    <div
                        class="w-16 h-16 rounded-2xl bg-white flex items-center justify-center text-indigo-600 shadow-sm mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-3xl">edit_note</span>
                    </div>
                    <h3 class="text-2xl font-black text-[#0f172a] mb-4">Quality Content</h3>
                    <p class="text-slate-500 leading-relaxed font-bold">Curated articles that focus on substance over
                        clickbait,
                        ensuring every read is valuable.</p>
                </div>
                <div
                    class="flex flex-col items-center p-10 bg-[#f8fafc] rounded-[2.5rem] text-center group hover:bg-white hover:shadow-2xl hover:shadow-slate-100 transition-all duration-300">
                    <div
                        class="w-16 h-16 rounded-2xl bg-white flex items-center justify-center text-indigo-600 shadow-sm mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-3xl">groups</span>
                    </div>
                    <h3 class="text-2xl font-black text-[#0f172a] mb-4">Community First</h3>
                    <p class="text-slate-500 leading-relaxed font-bold">A thriving space for discussion, meaningful
                        feedback, and
                        collective growth.</p>
                </div>
                <div
                    class="flex flex-col items-center p-10 bg-[#f8fafc] rounded-[2.5rem] text-center group hover:bg-white hover:shadow-2xl hover:shadow-slate-100 transition-all duration-300">
                    <div
                        class="w-16 h-16 rounded-2xl bg-white flex items-center justify-center text-indigo-600 shadow-sm mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-3xl">public</span>
                    </div>
                    <h3 class="text-2xl font-black text-[#0f172a] mb-4">Global Perspective</h3>
                    <p class="text-slate-500 leading-relaxed font-bold">Diverse stories and insights from creative minds
                        and
                        developers around the world.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Author Section -->
    <section class="py-24 bg-[#f8fafc]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div
                class="max-w-5xl mx-auto bg-white border border-slate-100 shadow-2xl rounded-[3rem] overflow-hidden flex flex-col md:flex-row">
                <div class="w-full md:w-2/5 h-80 md:h-auto overflow-hidden">
                    <img src="{{ asset('img/foto-profile.jpeg') }}" alt="Uri Indigo - Editor"
                        class="w-full h-full object-cover">
                </div>
                <div class="flex-1 p-10 md:p-16 flex flex-col justify-center">
                    <span class="text-indigo-600 font-black text-sm tracking-widest uppercase mb-4">Meet the
                        Editor</span>
                    <h3 class="text-4xl font-black text-[#0f172a] mb-6">Kholil Mustofa</h3>
                    <p class="text-lg text-slate-500 mb-8 leading-relaxed font-medium text-justify">
                        Developed by Kholil Mustofa, an Informatics student at Alma Ata University, this platform serves
                        as a practical project for the Semantic Web course. Uriblog aims to deliver insightful articles
                        that not only inform readers but also integrate structured data principles to enhance web
                        interoperability.
                    </p>
                    <div class="flex gap-6">
                        <a class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:text-white hover:bg-indigo-600 transition-all"
                            href="mailto:your-kholilmoestofa954@gmail.com">
                            <span class="material-symbols-outlined text-2xl">mail</span>
                        </a>
                        <a class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:text-white hover:bg-indigo-600 transition-all"
                            href="https://github.com/kholilmustofa" target="_blank">
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                                <path
                                    d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12" />
                            </svg>
                        </a>
                        <a class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:text-white hover:bg-indigo-600 transition-all"
                            href="https://www.linkedin.com/in/kholil-mustofa-25b669335" target="_blank">
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.761 0 5-2.239 5-5v-14c0-2.761-2.239-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter CTA -->
    <section class="py-24 bg-[#0f172a]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-4xl md:text-5xl font-black text-white mb-6 leading-tight">Join the community of
                    <br><span class="text-indigo-400">curious minds.</span>
                </h2>
                <p class="text-xl text-slate-400 mb-10 leading-relaxed max-w-2xl mx-auto font-bold">
                    Join our newsletter to get the latest stories, tutorials, and insights delivered straight to your
                    inbox.
                </p>
                <form class="flex flex-col sm:flex-row gap-4 max-w-2xl mx-auto">
                    <input
                        class="flex-1 h-16 px-6 rounded-2xl border-none bg-white/10 text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-400 focus:bg-white/20 transition-all text-lg"
                        placeholder="Enter your email address" type="email">
                    <button
                        class="h-16 px-10 bg-indigo-600 text-white font-black rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100/10 text-lg active:scale-95 transform"
                        type="button">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
    </section>
</x-layout>
