<x-app-layout>
    <x-slot name="header">
        Edit Story
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-posts.edit :post="$post" />
    </div>
</x-app-layout>
