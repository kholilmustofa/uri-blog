<div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
    <div class="p-8">
        <!-- Dashboard Navigation & Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <a href="/dashboard"
                class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-700 transition">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to all posts
            </a>

            <div class="flex items-center gap-3">
                <a href="/dashboard/{{ $post->slug }}/edit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    Edit Post
                </a>

                <form action="/dashboard/{{ $post->slug }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this post?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-red-200 text-red-600 text-sm font-semibold rounded-lg hover:bg-red-50 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <article class="max-w-4xl">
            <header class="mb-10">
                <!-- Category Badge -->
                <div class="mb-6">
                    <span
                        class="{{ $post->category->color }} text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">
                        {{ $post->category->name }}
                    </span>
                </div>

                <!-- Title -->
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight mb-8">
                    {{ $post->title }}
                </h1>

                <!-- Author & Meta -->
                <div class="flex items-center gap-4 pb-8 border-b border-gray-100">
                    <img class="w-12 h-12 rounded-full ring-2 ring-indigo-50"
                        src="{{ $post->author->avatar ? asset('storage/' . $post->author->avatar) : asset('img/avatar.png') }}"
                        alt="{{ $post->author->name }}">
                    <div>
                        <div class="font-bold text-gray-900 text-lg">{{ $post->author->name }}</div>
                        <div class="flex items-center gap-3 text-sm text-gray-500 mt-1">
                            <time datetime="{{ $post->created_at->toIso8601String() }}">
                                {{ $post->created_at->format('F d, Y') }}
                            </time>
                            <span>•</span>
                            <span>{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Article Body -->
            <div class="prose prose-lg prose-indigo max-w-none">
                {!! $post->body !!}
            </div>
        </article>
    </div>
</div>
