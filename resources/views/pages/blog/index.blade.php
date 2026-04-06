@extends('layouts.app')

@section('title', 'Travel Blog & Insights - StorySumba')
@section('meta_description', 'Explore travel tips, destination guides, and inspiration for your next luxury vacation.')

@section('content')
<!-- Hero Section -->
<section class="relative pt-32 pb-20">
    <div class="absolute inset-0">
        <img src="{{ asset('images/blog.jpg') }}" alt="Travel Blog" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-luxury-900/90 via-luxury-900/80 to-luxury-900/60"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block px-4 py-2 bg-red-500/20 text-red-400 rounded-full text-sm font-medium mb-6">
            Stories & Inspiration
        </span>
        <h1 class="font-display text-5xl md:text-6xl font-bold text-white mb-6">
            {{ __('messages.blog.title') }}
        </h1>
        <p class="text-xl text-white/80 max-w-2xl mx-auto">
            {{ __('messages.blog.subtitle') }}
        </p>
    </div>
</section>

<!-- Category Filter -->
<section class="py-8 bg-white border-b border-luxury-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-center gap-3">
            <a href="{{ route('blog.index') }}" class="px-5 py-2 bg-red-500 text-white rounded-full text-sm font-medium transition-all">
                All Posts
            </a>
            {{-- Tambahkan filter lain jika perlu --}}
        </div>
    </div>
</section>

<!-- Blog Grid -->
<section class="py-16 px-4">
    <div class="max-w-7xl mx-auto">
        @if($blogs->count() > 0)

        <!-- Featured Post -->
        <div class="mb-12">
            @php $featured = $blogs->first(); @endphp
            <a href="{{ route('blog.show', $featured->slug) }}" class="group block bg-white rounded-3xl shadow-luxury overflow-hidden hover:shadow-xl transition-all duration-500">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                    <div class="h-72 lg:h-auto overflow-hidden">
                        {{-- PERBAIKAN: Gunakan gambar dari DB jika ada --}}
                        <img src="{{ $featured->image ? asset('storage/' . $featured->image) : 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800' }}"
                             alt="{{ $featured->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    </div>
                    <div class="p-8 lg:p-12 flex flex-col justify-center">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-semibold uppercase tracking-wide">
                                {{ $featured->category }}
                            </span>
                            <span class="text-sm text-luxury-400">
                                {{ $featured->published_at->format('F d, Y') }}
                            </span>
                        </div>
                        <h2 class="font-display text-3xl lg:text-4xl font-bold text-luxury-900 mb-4 group-hover:text-red-600 transition-colors">
                            {{ $featured->title }}
                        </h2>
                        <p class="text-luxury-600 leading-relaxed mb-6 line-clamp-3">
                            {{ $featured->excerpt }}
                        </p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                <span class="font-bold text-red-600">{{ Str::substr($featured->user->name ?? 'A', 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-luxury-900">{{ $featured->user->name ?? 'Admin' }}</p>
                                <p class="text-sm text-luxury-500">Author</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Rest of the posts -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($blogs->skip(1) as $blog)
            <article class="group bg-white rounded-2xl shadow-luxury overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="relative h-52 overflow-hidden">
                    {{-- PERBAIKAN: Hapus kode $blogImages yang membingungkan. Langsung gunakan logic if/else biasa --}}
                    <img src="{{ $blog->image ? asset('storage/' . $blog->image) : 'https://images.unsplash.com/photo-1488085061387-422e29b40080?w=800' }}"
                         alt="{{ $blog->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-4 left-4 px-3 py-1 bg-red-500 text-white text-xs font-medium rounded-full">
                        {{ $blog->category }}
                    </div>
                </div>

                <div class="p-6">
                    <div class="flex items-center gap-2 text-xs text-luxury-400 mb-3">
                        <span>{{ $blog->published_at->format('M d, Y') }}</span>
                        <span>•</span>
                        <span>{{ ceil(str_word_count(strip_tags($blog->content_en ?? '')) / 200) }} min read</span>
                    </div>
                    <h3 class="font-display text-xl font-semibold text-luxury-900 mb-3 group-hover:text-red-600 transition-colors line-clamp-2">
                        {{ $blog->title }}
                    </h3>
                    <p class="text-luxury-500 text-sm mb-4 line-clamp-2">
                        {{ $blog->excerpt }}
                    </p>
                    <div class="flex items-center justify-between pt-4 border-t border-luxury-100">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-luxury-100 rounded-full flex items-center justify-center">
                                <span class="text-xs font-bold text-luxury-600">{{ Str::substr($blog->user->name ?? 'A', 0, 1) }}</span>
                            </div>
                            <span class="text-sm text-luxury-600">{{ $blog->user->name ?? 'Admin' }}</span>
                        </div>
                        <a href="{{ route('blog.show', $blog->slug) }}"
                        class="text-red-600 text-sm font-medium group-hover:underline">
                            Read More →
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <div class="mt-12 flex justify-center">
            {{ $blogs->links() }}
        </div>

        @else
        <div class="text-center py-20">
            <svg class="w-24 h-24 text-luxury-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
            </svg>
            <h3 class="text-xl font-display font-semibold text-luxury-700 mb-2">No articles yet</h3>
            <p class="text-luxury-500">Check back soon for travel tips and inspiration.</p>
        </div>
        @endif
    </div>
</section>
@endsection
