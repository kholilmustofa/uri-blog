<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-black text-[#0f172a] tracking-tight">
                Category Management
            </h2>
            <a href="{{ route('categories.create') }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all hover:-translate-y-0.5 shadow-lg shadow-indigo-100">
                <span class="material-symbols-outlined text-xl">add</span>
                New Category
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 rounded-2xl border border-green-100">
                    <p class="text-green-600 font-bold">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 rounded-2xl border border-red-100">
                    <p class="text-red-600 font-bold">{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-[2.5rem] border border-slate-100">
                <div class="p-8">
                    @if ($categories->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($categories as $category)
                                <div
                                    class="group bg-white border-2 border-slate-100 rounded-2xl p-6 hover:border-indigo-600 hover:shadow-xl hover:shadow-indigo-50 transition-all">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                                                style="background-color: {{ $category->color }}20">
                                                <span class="material-symbols-outlined text-2xl"
                                                    style="color: {{ $category->color }}">label</span>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-black text-[#0f172a]">{{ $category->name }}</h3>
                                                <p class="text-xs text-slate-400 font-bold">{{ $category->slug }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2 mb-4">
                                        <span class="text-sm font-bold text-slate-600">{{ $category->posts_count }}
                                            posts</span>
                                        <span class="text-slate-300">•</span>
                                        <div class="w-6 h-6 rounded-lg"
                                            style="background-color: {{ $category->color }}"></div>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('categories.show', $category) }}"
                                            class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-slate-50 text-[#0f172a] font-bold rounded-xl hover:bg-slate-100 transition-all text-sm">
                                            <span class="material-symbols-outlined text-lg">visibility</span>
                                            View
                                        </a>
                                        <a href="{{ route('categories.edit', $category) }}"
                                            class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-600 font-bold rounded-xl hover:bg-indigo-100 transition-all text-sm">
                                            <span class="material-symbols-outlined text-lg">edit</span>
                                            Edit
                                        </a>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this category?');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-red-50 text-red-600 font-bold rounded-xl hover:bg-red-100 transition-all text-sm">
                                                <span class="material-symbols-outlined text-lg">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div
                                class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <span class="material-symbols-outlined text-5xl text-slate-300">label_off</span>
                            </div>
                            <h3 class="text-2xl font-black text-[#0f172a] mb-2">No Categories Yet</h3>
                            <p class="text-slate-500 font-bold mb-6">Create your first category to organize your posts.
                            </p>
                            <a href="{{ route('categories.create') }}"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all hover:-translate-y-0.5 shadow-lg shadow-indigo-100">
                                <span class="material-symbols-outlined text-xl">add</span>
                                Create Category
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
