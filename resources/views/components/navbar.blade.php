<nav class="bg-white shadow-sm fixed top-0 w-full z-50" x-data="{ isOpen: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <!-- Logo & Brand -->
            <div class="flex items-center">
                <a href="/" class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-900">Uri Blog</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex md:items-center md:space-x-8">
                <a href="/"
                    class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition {{ request()->is('/') ? 'text-indigo-600' : '' }}">
                    Home
                </a>
                <a href="/posts"
                    class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition {{ request()->is('posts*') ? 'text-indigo-600' : '' }}">
                    Blog
                </a>
                <a href="/about"
                    class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition {{ request()->is('about') ? 'text-indigo-600' : '' }}">
                    About
                </a>
                <a href="/contact"
                    class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition {{ request()->is('contact') ? 'text-indigo-600' : '' }}">
                    Contact
                </a>
            </div>

            <!-- Auth Section -->
            <div class="hidden md:flex md:items-center md:space-x-4">
                @if (Auth::check())
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" type="button"
                            class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600 focus:outline-none">
                            <img class="w-8 h-8 rounded-full ring-2 ring-gray-200"
                                src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('img/avatar.png') }}"
                                alt="{{ Auth::user()->name }}">
                            <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 ring-1 ring-black ring-opacity-5"
                            style="display: none;">
                            <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your
                                Profile</a>
                            <a href="/dashboard"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                            <form method="POST" action="/logout">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Log out
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="/login"
                        class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition">
                        Login
                    </a>
                    <a href="/register"
                        class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                        Register
                    </a>
                @endif
            </div>

            <!-- Mobile menu button -->
            <div class="flex md:hidden">
                <button @click="isOpen = !isOpen" type="button"
                    class="inline-flex items-center justify-center p-2 rounded-lg text-gray-700 hover:text-indigo-600 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" :class="{ 'hidden': isOpen, 'block': !isOpen }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg class="h-6 w-6" :class="{ 'block': isOpen, 'hidden': !isOpen }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="isOpen" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95" class="md:hidden" style="display: none;">
        <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t border-gray-200">
            <a href="/"
                class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 {{ request()->is('/') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                Home
            </a>
            <a href="/posts"
                class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 {{ request()->is('posts*') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                Blog
            </a>
            <a href="/about"
                class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 {{ request()->is('about') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                About
            </a>
            <a href="/contact"
                class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 {{ request()->is('contact') ? 'bg-indigo-600' : '' }}">
                Contact
            </a>

            @if (Auth::check())
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <div class="flex items-center px-3 mb-3">
                        <img class="w-10 h-10 rounded-full"
                            src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('img/avatar.png') }}"
                            alt="{{ Auth::user()->name }}">
                        <div class="ml-3">
                            <div class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <a href="/profile" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100">Your
                        Profile</a>
                    <a href="/dashboard"
                        class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100">Dashboard</a>
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100">
                            Log out
                        </button>
                    </form>
                </div>
            @else
                <div class="border-t border-gray-200 pt-4 mt-4 space-y-2">
                    <a href="/login" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100">
                        Login
                    </a>
                    <a href="/register"
                        class="block px-3 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 text-center">
                        Register
                    </a>
                </div>
            @endif
        </div>
    </div>
</nav>
