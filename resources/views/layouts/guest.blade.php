<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen flex">
        <!-- Left Side - Form -->
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div>
                    <a href="/" class="flex items-center space-x-3">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-gray-900">Uri Blog</span>
                    </a>
                    <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                        {{ $title ?? 'Welcome back' }}
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        {{ $subtitle ?? 'Sign in to your account' }}
                    </p>
                </div>

                <div class="mt-8">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <!-- Right Side - Image/Gradient -->
        <div class="hidden lg:block relative w-0 flex-1">
            <div
                class="absolute inset-0 bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center">
                <div class="text-center text-white px-12">
                    <svg class="mx-auto h-24 w-24 text-white opacity-50 mb-8" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    <h3 class="text-3xl font-bold mb-4">Welcome to Uri Blog</h3>
                    <p class="text-lg text-indigo-100">Your source for insightful articles and stories</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
