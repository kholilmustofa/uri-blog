<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-[#f8fafc] overflow-x-hidden min-h-screen relative">
    <!-- Sophisticated Background Elements -->
    <div
        class="fixed top-0 right-0 -translate-y-1/2 translate-x-1/2 w-[600px] h-[600px] bg-indigo-100/30 rounded-full blur-[120px] pointer-events-none">
    </div>
    <div
        class="fixed bottom-0 left-0 translate-y-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-indigo-100/30 rounded-full blur-[120px] pointer-events-none">
    </div>

    <div class="min-h-screen flex items-center justify-center p-6 sm:p-12 relative z-10">
        <div
            class="w-full max-w-[1000px] flex flex-col md:flex-row bg-white rounded-[3rem] shadow-[0_32px_128px_-16px_rgba(0,0,0,0.08)] overflow-hidden border border-slate-100/50">

            <!-- Left Side: Visual Experience -->
            <div
                class="hidden md:flex md:w-[45%] bg-[#fcfdfe] flex-col justify-between p-16 border-r border-slate-50 relative overflow-hidden">
                <div class="absolute inset-0 opacity-40 pointer-events-none">
                    <div class="absolute top-10 left-10 w-40 h-40 bg-indigo-100/40 rounded-full blur-3xl"></div>
                </div>

                <div class="relative z-10">
                    <a href="/" class="flex items-center gap-3 group">
                        <div
                            class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-all">
                            <span class="material-symbols-outlined text-white text-xl">article</span>
                        </div>
                        <h2 class="text-2xl font-black tracking-tight text-[#0f172a]">uriblog</h2>
                    </a>
                </div>

                <div class="relative z-10 py-12">
                    <img src="{{ asset('img/auth_illustration_indigo.png') }}" alt="Editorial illustration"
                        class="w-full max-w-[280px] mx-auto drop-shadow-2xl animate-float">
                </div>

                <div class="relative z-10">
                    <h3 class="text-2xl font-black text-[#0f172a] leading-tight mb-4">Crafting the future of <span
                            class="text-indigo-600">digital editorial</span> content.</h3>
                    <div class="flex items-center gap-3">
                        @php
                            $creators = \App\Models\User::latest()->limit(4)->get();
                        @endphp
                        <div class="flex -space-x-3">
                            @foreach ($creators as $creator)
                                <img class="w-10 h-10 rounded-full border-2 border-white object-cover shadow-sm hover:translate-y-[-2px] transition-transform cursor-pointer"
                                    src="{{ $creator->avatar ? asset('storage/' . $creator->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($creator->name) . '&background=EEF2FF&color=4F46E5' }}"
                                    alt="{{ $creator->name }}" title="{{ $creator->name }}">
                            @endforeach
                        </div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                            +{{ \App\Models\User::count() }} Creators
                            joined
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Side: The Form Content -->
            <div class="flex-1 p-12 sm:p-20 lg:p-24 relative flex flex-col justify-center">
                <div class="md:hidden mb-12">
                    <a href="/" class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-xl">article</span>
                        </div>
                        <h2 class="text-2xl font-black tracking-tight text-[#0f172a]">uriblog</h2>
                    </a>
                </div>

                <div class="max-w-md mx-auto w-full">
                    <div class="mb-12">
                        <h2 class="text-4xl font-black text-[#0f172a] tracking-tight leading-tight mb-4">
                            {{ $title ?? 'Welcome back' }}
                        </h2>
                        <p class="text-slate-500 font-bold leading-relaxed">
                            {{ $subtitle ?? 'Sign in to manage your digital laboratory.' }}
                        </p>
                    </div>

                    <div class="relative">
                        {{ $slot }}
                    </div>

                    <div class="mt-16 pt-8 border-t border-slate-50 text-center">
                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em]">
                            &copy; {{ date('Y') }} Uri Blog Editorial Systems
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <style>
        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</body>

</html>
