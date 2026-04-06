@extends('layouts.admin')

@section('title', $blog->title_en)

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.blogs.index') }}" class="inline-flex items-center gap-2 text-luxury-600 hover:text-red-600 transition-colors text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Posts
    </a>
</div>

<div class="bg-white rounded-2xl shadow-luxury overflow-hidden">
    <!-- Header -->
    <div class="p-8 border-b border-luxury-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-semibold uppercase tracking-wide">
                        {{ $blog->category }}
                    </span>
                    @if($blog->is_published)
                        <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-semibold uppercase tracking-wide">
                            Published
                        </span>
                    @else
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-semibold uppercase tracking-wide">
                            Draft
                        </span>
                    @endif
                </div>
                <h1 class="font-display text-3xl font-bold text-luxury-900">{{ $blog->title_en }}</h1>
                <p class="text-luxury-500 mt-1">{{ $blog->title_id }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="px-4 py-2 bg-red-500 text-white rounded-lg text-sm font-medium hover:bg-red-600 transition-colors">
                    Edit Post
                </a>
                <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-100 text-red-600 rounded-lg text-sm font-medium hover:bg-red-200 transition-colors">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Featured Image -->
    @if($blog->image)
    <div class="w-full h-80 bg-luxury-50">
        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title_en }}" class="w-full h-full object-cover">
    </div>
    @endif

    <!-- Content Body -->
    <div class="p-8 grid grid-cols-1 lg:grid-cols-2 gap-12">

        <!-- English Version -->
        <div>
            <h3 class="text-lg font-semibold text-luxury-900 mb-4 flex items-center gap-2">
                <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">EN</span>
                English Content
            </h3>

            <div class="mb-6">
                <h4 class="text-xs font-semibold text-luxury-400 uppercase tracking-wide mb-1">Excerpt</h4>
                <p class="text-luxury-600 text-sm leading-relaxed bg-luxury-50 p-4 rounded-xl">{{ $blog->excerpt_en }}</p>
            </div>

            <div>
                <h4 class="text-xs font-semibold text-luxury-400 uppercase tracking-wide mb-1">Content</h4>
                <div class="prose prose-sm max-w-none text-luxury-700">
                    {!! $blog->content_en !!}
                </div>
            </div>
        </div>

        <!-- Indonesian Version -->
        <div>
            <h3 class="text-lg font-semibold text-luxury-900 mb-4 flex items-center gap-2">
                <span class="w-6 h-6 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-xs font-bold">ID</span>
                Indonesian Content
            </h3>

            <div class="mb-6">
                <h4 class="text-xs font-semibold text-luxury-400 uppercase tracking-wide mb-1">Excerpt</h4>
                <p class="text-luxury-600 text-sm leading-relaxed bg-luxury-50 p-4 rounded-xl">{{ $blog->excerpt_id }}</p>
            </div>

            <div>
                <h4 class="text-xs font-semibold text-luxury-400 uppercase tracking-wide mb-1">Content</h4>
                <div class="prose prose-sm max-w-none text-luxury-700">
                    {!! $blog->content_id !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Metadata Footer -->
    <div class="p-8 bg-luxury-50 border-t border-luxury-100 grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
        <div>
            <p class="text-luxury-400 font-medium mb-1">Author</p>
            <p class="text-luxury-900 font-semibold">{{ $blog->user->name ?? 'Unknown' }}</p>
        </div>
        <div>
            <p class="text-luxury-400 font-medium mb-1">Published At</p>
            <p class="text-luxury-900 font-semibold">{{ $blog->published_at ? $blog->published_at->format('F d, Y H:i') : 'Not Published' }}</p>
        </div>
        <div>
            <p class="text-luxury-400 font-medium mb-1">Tags</p>
            <div class="flex flex-wrap gap-2">
                @if($blog->tags && count($blog->tags) > 0)
                    @foreach($blog->tags as $tag)
                        <span class="px-2 py-1 bg-white border border-luxury-200 rounded text-xs text-luxury-600">{{ $tag }}</span>
                    @endforeach
                @else
                    <span class="text-luxury-400">No tags</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
