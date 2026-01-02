@push('style')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <style>
        .ql-editor {
            min-height: 400px;
            font-size: 1.125rem;
            line-height: 1.75;
            font-family: 'Inter', sans-serif;
            color: #0f172a;
            padding: 2rem;
        }

        .ql-container.ql-snow {
            border: none !important;
            background: white;
        }

        .ql-toolbar.ql-snow {
            border: none !important;
            border-bottom: 1px solid #f1f5f9 !important;
            padding: 1rem 2rem !important;
            background: #f8fafc;
            border-top-left-radius: 1.5rem;
            border-top-right-radius: 1.5rem;
        }

        .ql-editor.ql-blank::before {
            left: 2rem;
            color: #94a3b8;
            font-style: normal;
            font-weight: 500;
        }

        select {
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
            background-image: none !important;
        }

        select::-ms-expand {
            display: none !important;
        }
    </style>
@endpush

<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden mb-12">
    <div class="p-8 sm:p-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div>
                <h3 class="text-3xl font-black text-[#0f172a] tracking-tight">Write New Story</h3>
                <p class="text-slate-500 mt-2 font-bold leading-relaxed">Fill in the details below to share your
                    perspective with the world.</p>
            </div>
            <div class="hidden md:block">
                <span
                    class="px-4 py-2 bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-widest rounded-full">New
                    Draft</span>
            </div>
        </div>

        <form action="/dashboard" method="POST" id="post-form" enctype="multipart/form-data" class="space-y-10">
            @csrf

            <!-- Featured Image -->
            <div class="space-y-4">
                <label
                    class="text-[#0f172a] text-xs font-black uppercase tracking-widest block">{{ __('Cover Image') }}</label>
                <div class="relative group">
                    <div id="image-preview-container"
                        class="hidden relative w-full aspect-video rounded-3xl overflow-hidden border-2 border-slate-100 mb-4 bg-slate-50">
                        <img id="image-preview" src="#" alt="Preview" class="w-full h-full object-cover">
                        <button type="button" onclick="removeImage()"
                            class="absolute top-4 right-4 w-10 h-10 bg-white/90 backdrop-blur-sm text-red-600 rounded-xl flex items-center justify-center shadow-lg hover:bg-red-50 transition-all">
                            <span class="material-symbols-outlined">delete</span>
                        </button>
                    </div>

                    <label id="upload-placeholder"
                        class="cursor-pointer flex flex-col items-center justify-center w-full aspect-video rounded-3xl border-2 border-dashed border-slate-200 bg-slate-50 hover:bg-indigo-50/50 hover:border-indigo-200 transition-all group">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <div
                                class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-sm mb-4 group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-3xl text-indigo-600">image</span>
                            </div>
                            <p class="text-sm font-black text-[#0f172a] uppercase tracking-widest">Click to upload cover
                            </p>
                            <p class="text-xs text-slate-400 font-bold mt-2">PNG, JPG or WEBP (Max. 2MB)</p>
                        </div>
                        <input type="file" name="image" id="image-input" class="hidden" accept="image/*"
                            onchange="previewImage(this)" />
                    </label>
                </div>
                @error('image')
                    <p class="text-xs text-red-600 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Title -->
                <div class="space-y-2">
                    <label for="title"
                        class="text-[#0f172a] text-xs font-black uppercase tracking-widest block">{{ __('Story Title') }}</label>
                    <input type="text" name="title" id="title"
                        class="w-full h-14 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 px-6 text-[#0f172a] placeholder-slate-400 transition-all outline-none font-bold"
                        placeholder="Enter an engaging title..." autofocus value="{{ old('title') }}">
                    @error('title')
                        <p class="text-xs text-red-600 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div class="space-y-2">
                    <label for="category"
                        class="text-[#0f172a] text-xs font-black uppercase tracking-widest block">{{ __('Category') }}</label>
                    <div class="relative">
                        <select name="category_id" id="category"
                            class="w-full h-14 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 px-6 text-[#0f172a] transition-all outline-none font-bold appearance-none">
                            <option value="">Select post category</option>
                            @foreach (App\Models\Category::get() as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none">
                            <span class="material-symbols-outlined text-slate-400">expand_more</span>
                        </div>
                    </div>
                    @error('category_id')
                        <p class="text-xs text-red-600 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Body -->
            <div class="space-y-4">
                <label for="body"
                    class="text-[#0f172a] text-xs font-black uppercase tracking-widest block">{{ __('Content') }}</label>
                <div class="rounded-3xl border border-slate-100 overflow-hidden shadow-sm">
                    <textarea id="body" name="body" rows="4" class="hidden">{{ old('body') }}</textarea>
                    <div id="editor"></div>
                </div>
                @error('body')
                    <p class="text-xs text-red-600 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="pt-10 flex flex-col sm:flex-row items-center gap-4">
                <button type="submit"
                    class="w-full sm:w-auto h-14 px-10 bg-indigo-600 text-white font-black rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 transform active:scale-95 transition-all flex items-center justify-center gap-3 uppercase tracking-widest text-xs">
                    <span class="material-symbols-outlined text-xl">publish</span>
                    Publish Story
                </button>
                <a href="/dashboard"
                    class="w-full sm:w-auto h-14 px-10 bg-slate-50 text-[#0f172a] font-black rounded-2xl hover:bg-slate-100 transition-all flex items-center justify-center uppercase tracking-widest text-xs">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script>
        const quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'Start writing your amazing story...',
        });

        const initialContent = `{!! old('body') !!}`;
        if (initialContent) {
            quill.root.innerHTML = initialContent;
        }

        const postForm = document.querySelector('#post-form');
        const postBody = document.querySelector('#body');

        postForm.addEventListener('submit', function(e) {
            e.preventDefault();
            postBody.value = quill.root.innerHTML;
            this.submit();
        });

        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const container = document.getElementById('image-preview-container');
            const placeholder = document.getElementById('upload-placeholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeImage() {
            const input = document.getElementById('image-input');
            const preview = document.getElementById('image-preview');
            const container = document.getElementById('image-preview-container');
            const placeholder = document.getElementById('upload-placeholder');

            input.value = "";
            preview.src = "#";
            container.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }
    </script>
@endpush
