<header class="sticky top-0 z-50 w-full bg-white/95 backdrop-blur-sm border-b border-slate-100" x-data="{ isOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-[72px] flex items-center justify-between">
        <!-- Logo -->
        <a href="/" class="flex items-center gap-3 group">
            <span
                class="material-symbols-outlined text-3xl text-indigo-600 group-hover:scale-110 transition-transform">article</span>
            <h2 class="text-xl font-bold tracking-tight text-[#0f172a]">uriblog</h2>
        </a>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex items-center gap-8">
            <a href="/"
                class="text-sm font-bold transition-colors {{ request()->is('/') ? 'text-indigo-600' : 'text-[#0f172a] hover:text-indigo-600' }}">Home</a>
            <a href="/posts"
                class="text-sm font-bold transition-colors {{ request()->is('posts*') ? 'text-indigo-600' : 'text-[#0f172a] hover:text-indigo-600' }}">Blog</a>
            <a href="/about"
                class="text-sm font-bold transition-colors {{ request()->is('about') ? 'text-indigo-600' : 'text-[#0f172a] hover:text-indigo-600' }}">About</a>
            <a href="/contact"
                class="text-sm font-bold transition-colors {{ request()->is('contact') ? 'text-indigo-600' : 'text-[#0f172a] hover:text-indigo-600' }}">Contact</a>
        </div>

        <!-- Desktop Actions -->
        <div class="hidden md:flex items-center gap-4">
            @if (Auth::check())
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" type="button"
                        class="flex items-center gap-2 group focus:outline-none">
                        <img class="w-9 h-9 rounded-full border-2 border-indigo-100 group-hover:border-indigo-600 transition-all"
                            src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=EEF2FF&color=4F46E5' }}"
                            alt="{{ Auth::user()->name }}">
                        <span class="text-sm font-bold text-[#0f172a]">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 transition-transform text-slate-400 group-hover:text-indigo-600"
                            :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-3 w-48 bg-white rounded-2xl shadow-2xl py-2 border border-slate-100 ring-1 ring-black/5 z-50">
                        <a href="/profile"
                            class="block px-6 py-2.5 text-sm font-bold text-[#0f172a] hover:bg-slate-50 hover:text-indigo-600">Profile</a>
                        <a href="/dashboard"
                            class="block px-6 py-2.5 text-sm font-bold text-[#0f172a] hover:bg-slate-50 hover:text-indigo-600">Dashboard</a>
                        <hr class="my-2 border-slate-50">
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-6 py-2.5 text-sm font-bold text-red-500 hover:bg-red-50">Log
                                out</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="/login"
                    class="h-10 px-6 flex items-center justify-center rounded-xl bg-slate-50 text-[#0f172a] text-sm font-bold hover:bg-slate-100 transition-colors">Login</a>
                <a href="/register"
                    class="h-10 px-6 flex items-center justify-center rounded-xl bg-indigo-600 text-white text-sm font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 active:scale-95">Register</a>
            @endif
        </div>

        <!-- Mobile Toggle -->
        <button @click="isOpen = !isOpen" class="md:hidden text-[#0f172a]">
            <span class="material-symbols-outlined" x-text="isOpen ? 'close' : 'menu'"></span>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div x-show="isOpen" x-transition class="md:hidden border-t border-slate-100 bg-white">
        <div class="px-4 py-6 flex flex-col gap-4">
            <a href="/"
                class="px-4 py-3 rounded-xl font-bold text-[#0f172a] {{ request()->is('/') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-slate-50' }}">Home</a>
            <a href="/posts"
                class="px-4 py-3 rounded-xl font-bold text-[#0f172a] {{ request()->is('posts*') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-slate-50' }}">Blog</a>
            <a href="/about"
                class="px-4 py-3 rounded-xl font-bold text-[#0f172a] {{ request()->is('about') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-slate-50' }}">About</a>
            <a href="/contact"
                class="px-4 py-3 rounded-xl font-bold text-[#0f172a] {{ request()->is('contact') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-slate-50' }}">Contact</a>

            <div class="mt-4 pt-6 border-t border-slate-100 flex flex-col gap-3">
                @if (Auth::check())
                    <div class="flex items-center gap-4 px-4 mb-4">
                        <img class="w-12 h-12 rounded-full ring-2 ring-indigo-100"
                            src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=EEF2FF&color=4F46E5' }}"
                            alt="">
                        <div>
                            <p class="font-black text-[#0f172a]">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                @else
                    <a href="/login"
                        class="h-12 flex items-center justify-center rounded-xl bg-slate-50 text-[#0f172a] font-bold">Login</a>
                    <a href="/register"
                        class="h-12 flex items-center justify-center rounded-xl bg-indigo-600 text-white font-bold">Register</a>
                @endif
            </div>
        </div>
    </div>
</header>
