@push('style')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <style>
        .ql-editor {
            min-height: 250px;
            font-size: 1rem;
        }

        .ql-container {
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
        }

        .ql-toolbar {
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            background-color: #f9fafb;
        }
    </style>
@endpush

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-8">
        <div class="mb-8">
            <h3 class="text-2xl font-bold text-gray-900">Edit Post</h3>
            <p class="text-gray-500 mt-1 text-sm">Make changes to your article below.</p>
        </div>

        <form action="/dashboard/{{ $post->slug }}" method="POST" id="post-form" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- Title Field -->
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Title</label>
                <input type="text" name="title" id="title"
                    class="block w-full px-4 py-3 border @error('title') border-red-300 bg-red-50 text-red-900 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition sm:text-sm"
                    placeholder="Enter an engaging title..." value="{{ old('title', $post->title) }}">
                @error('title')
                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category Field -->
            <div>
                <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                <select name="category_id" id="category"
                    class="block w-full px-4 py-3 border @error('category_id') border-red-300 bg-red-50 text-red-900 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition sm:text-sm">
                    <option value="">Select post category</option>
                    @foreach (App\Models\Category::get() as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id) == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Body Field -->
            <div>
                <label for="body" class="block text-sm font-semibold text-gray-700 mb-2">Content</label>
                <textarea id="body" name="body" rows="4" class="hidden">{{ old('body', $post->body) }}</textarea>
                <div id="editor" class="@error('body') border-red-300 @enderror rounded-lg"></div>
                @error('body')
                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="pt-6 flex flex-col sm:flex-row gap-3 border-t border-gray-100">
                <button type="submit"
                    class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-100 transition shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Save Changes
                </button>
                <a href="/dashboard"
                    class="inline-flex items-center justify-center px-6 py-3 border border-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
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
            placeholder: 'Share your thoughts with the world...',
        });

        // Set initial content
        quill.root.innerHTML = `{!! old('body', $post->body) !!}`;

        const postForm = document.querySelector('#post-form');
        const postBody = document.querySelector('#body');

        postForm.addEventListener('submit', function(e) {
            e.preventDefault();
            postBody.value = quill.root.innerHTML;
            this.submit();
        });
    </script>
@endpush
