<nav x-data="{ open: false }" class="bg-white border-b border-slate-100 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/" class="flex items-center gap-3 group">
                        <span
                            class="material-symbols-outlined text-3xl text-indigo-600 group-hover:scale-110 transition-transform">article</span>
                        <h2 class="text-xl font-bold tracking-tight text-[#0f172a]">uriblog</h2>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        class="text-sm font-black uppercase tracking-widest">
                        {{ __('My Stories') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
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
                        <x-dropdown-link :href="route('dashboard')"
                            class="px-6 py-2.5 text-sm font-bold text-[#0f172a] hover:bg-slate-50 hover:text-indigo-600">
                            {{ __('Dashboard') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('profile.edit')"
                            class="px-6 py-2.5 text-sm font-bold text-[#0f172a] hover:bg-slate-50 hover:text-indigo-600">
                            {{ __('My Profile') }}
                        </x-dropdown-link>
                        <hr class="my-2 border-slate-50">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-6 py-2.5 text-sm font-bold text-red-500 hover:bg-red-50">
                                {{ __('Sign Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-3 rounded-2xl text-slate-400 hover:text-[#0f172a] hover:bg-slate-50 transition-all">
                    <span class="material-symbols-outlined" x-show="!open">menu</span>
                    <span class="material-symbols-outlined" x-show="open" x-cloak>close</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden border-t border-slate-50">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="font-black uppercase tracking-widest text-xs">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-slate-100">
            <div class="flex items-center px-5 py-4">
                <div class="shrink-0">
                    <img class="w-12 h-12 rounded-2xl object-cover border-2 border-white shadow-md"
                        src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=4f46e5&background=EEF2FF' }}"
                        alt="{{ Auth::user()->name }}">
                </div>
                <div class="px-4">
                    <div class="font-black text-sm text-[#0f172a] uppercase tracking-wide">{{ Auth::user()->name }}
                    </div>
                    <div class="font-bold text-xs text-slate-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1 px-3 pb-6">
                <x-responsive-nav-link :href="route('profile.edit')" class="rounded-xl font-bold">
                    {{ __('Profile Settings') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="rounded-xl font-bold text-red-600">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
