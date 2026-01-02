<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('categories.index') }}"
                class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center hover:bg-slate-200 transition-all">
                <span class="material-symbols-outlined text-[#0f172a]">arrow_back</span>
            </a>
            <h2 class="text-3xl font-black text-[#0f172a] tracking-tight">
                Create New Category
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-[2.5rem] border border-slate-100">
                <div class="p-8">
                    <form action="{{ route('categories.store') }}" method="POST" x-data="categoryForm()">
                        @csrf

                        <!-- Category Name -->
                        <div class="mb-6">
                            <label for="name"
                                class="block text-sm font-black text-[#0f172a] mb-2 uppercase tracking-wider">
                                Category Name *
                            </label>
                            <input type="text" name="name" id="name" x-model="name" @input="generateSlug"
                                class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 focus:ring-0 focus:bg-white transition-all font-bold text-[#0f172a] placeholder:text-slate-400"
                                placeholder="e.g., Technology, Lifestyle, Travel" value="{{ old('name') }}" required>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 font-bold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category Slug -->
                        <div class="mb-6">
                            <label for="slug"
                                class="block text-sm font-black text-[#0f172a] mb-2 uppercase tracking-wider">
                                Slug (URL-friendly)
                            </label>
                            <input type="text" name="slug" id="slug" x-model="slug"
                                class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 focus:ring-0 focus:bg-white transition-all font-bold text-[#0f172a] placeholder:text-slate-400"
                                placeholder="Auto-generated from name" value="{{ old('slug') }}">
                            <p class="mt-2 text-xs text-slate-500 font-bold">Leave empty to auto-generate from category
                                name</p>
                            @error('slug')
                                <p class="mt-2 text-sm text-red-600 font-bold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category Color -->
                        <div class="mb-8">
                            <label for="color"
                                class="block text-sm font-black text-[#0f172a] mb-3 uppercase tracking-wider">
                                Category Color *
                            </label>

                            <!-- Color Presets -->
                            <div class="grid grid-cols-8 gap-3 mb-4">
                                <template x-for="preset in colorPresets" :key="preset">
                                    <button type="button" @click="color = preset"
                                        class="w-12 h-12 rounded-xl transition-all hover:scale-110"
                                        :class="color === preset ? 'ring-4 ring-indigo-600 ring-offset-2' : ''"
                                        :style="`background-color: ${preset}`">
                                    </button>
                                </template>
                            </div>

                            <!-- Custom Color Picker -->
                            <div class="flex items-center gap-4">
                                <input type="color" name="color" id="color" x-model="color"
                                    class="w-20 h-12 rounded-xl cursor-pointer border-2 border-slate-100">
                                <div class="flex-1">
                                    <input type="text" x-model="color"
                                        class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-indigo-600 focus:ring-0 font-mono font-bold text-[#0f172a]"
                                        placeholder="#000000">
                                </div>
                                <div class="px-6 py-3 rounded-xl font-black text-sm"
                                    :style="`background-color: ${color}20; color: ${color}`">
                                    Preview
                                </div>
                            </div>
                            @error('color')
                                <p class="mt-2 text-sm text-red-600 font-bold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-4 pt-6 border-t border-slate-100">
                            <a href="{{ route('categories.index') }}"
                                class="px-6 py-3 bg-slate-100 text-[#0f172a] font-bold rounded-2xl hover:bg-slate-200 transition-all">
                                Cancel
                            </a>
                            <button type="submit"
                                class="flex-1 px-6 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all hover:-translate-y-0.5 shadow-lg shadow-indigo-100">
                                Create Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function categoryForm() {
            return {
                name: '{{ old('name') }}',
                slug: '{{ old('slug') }}',
                color: '{{ old('color', '#4f46e5') }}',
                colorPresets: [
                    '#4f46e5', // Indigo
                    '#ef4444', // Red
                    '#f59e0b', // Amber
                    '#10b981', // Green
                    '#3b82f6', // Blue
                    '#8b5cf6', // Purple
                    '#ec4899', // Pink
                    '#06b6d4', // Cyan
                ],
                generateSlug() {
                    if (!this.slug || this.slug === this.slugify(this.oldName)) {
                        this.slug = this.slugify(this.name);
                    }
                    this.oldName = this.name;
                },
                slugify(text) {
                    return text
                        .toString()
                        .toLowerCase()
                        .trim()
                        .replace(/\s+/g, '-')
                        .replace(/[^\w\-]+/g, '')
                        .replace(/\-\-+/g, '-');
                }
            }
        }
    </script>
</x-app-layout>
