<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Uri Blog - Your source for insightful articles and stories">
    <meta name="author" content="Uri Blog">
    <meta name="keywords" content="blog, articles, Uri Blog">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $title }} - Uri Blog">
    <meta property="og:description" content="Uri Blog - Your source for insightful articles and stories">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="{{ $title }} - Uri Blog">

    <title>{{ $title }} - Uri Blog</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="h-full flex flex-col">
    <div class="min-h-full flex flex-col">
        <!-- Navigation -->
        <x-navbar />

        <!-- Page Header -->
        <x-header :title="$title" />

        <!-- Main Content -->
        <main role="main" class="flex-grow">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>

        <!-- Footer -->
        <x-footer />
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>
