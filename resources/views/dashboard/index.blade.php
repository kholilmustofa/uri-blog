<x-app-layout>
    <x-slot name="header">
        My Stories
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <x-posts.table :posts="$posts" />
        </div>
    </div>
</x-app-layout>
