@extends('layouts.app')

@section('title', $blog->title . ' - StorySumba Blog')
@section('meta_description', $blog->excerpt)

@section('content')
<!-- Article Header -->
<article class="pt-32 pb-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-2 text-luxury-500 text-sm mb-8">
            <a href="{{ route('home') }}" class="hover:text-red-600 transition-colors">Home</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <a href="{{ route('blog.index') }}" class="hover:text-red-600 transition-colors">Blog</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-luxury-700 truncate w-32">{{ $blog->title }}</span>
        </nav>

        <!-- Category & Date -->
        <div class="flex items-center gap-4 mb-6">
            <span class="px-4 py-1.5 bg-red-500 text-white text-sm font-semibold rounded-full">
                {{ $blog->category }}
            </span>
            <span class="text-luxury-500">
                {{ $blog->published_at->format('F d, Y') }}
            </span>
        </div>

        <!-- Title -->
        <h1 class="font-display text-4xl md:text-5xl font-bold text-luxury-900 leading-tight mb-6">
            {{ $blog->title }}
        </h1>

        <!-- Excerpt -->
        <p class="text-xl text-luxury-600 leading-relaxed mb-8">
            {{ $blog->excerpt }}
        </p>

        <!-- Author Info -->
        <div class="flex items-center gap-4 pb-8 border-b border-luxury-200 mb-8">
            <div class="w-12 h-12 bg-gradient-to-br from-red-400 to-red-600 rounded-full flex items-center justify-center">
                <span class="text-white font-bold text-lg">{{ Str::substr($blog->user->name, 0, 1) }}</span>
            </div>
            <div>
                <p class="font-semibold text-luxury-900">{{ $blog->user->name }}</p>
                <p class="text-sm text-luxury-500">Author • {{ $blog->published_at->diffForHumans() }}</p>
            </div>
        </div>

        <!-- Featured Image -->
        <div class="rounded-3xl overflow-hidden shadow-luxury mb-12">
            @php
            $blogImages = [
                'luxury' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=1200',
                'slow' => 'https://images.unsplash.com/photo-1530789253388-582c481c54b0?w=1200',
                'honeymoon' => 'https://images.unsplash.com/photo-1516549655169-df83a0774514?w=1200',
            ];
            $blogImage = collect($blogImages)->first(function($img, $key) use ($blog) {
                return str_contains(strtolower($blog->title_en), $key);
            });
            @endphp
            <img src="{{ $blog->image
    ? asset('storage/' . $blog->image)
    : 'https://images.unsplash.com/photo-1488085061387-422e29b40080?w=1200' }}"
     alt="{{ $blog->title }}"
     class="w-full h-96 object-cover">
        </div>
    </div>

    <!-- Article Content -->
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-lg prose-luxury max-w-none">
            {{-- Output content safely. In production, consider using a WYSIWYG sanitizer --}}
            {!! $blog->content !!}

            {{-- Demo Content if empty --}}
            @if(empty($blog->content))
            <p class="lead">
                Travel opens our eyes to new cultures, breathtaking landscapes, and unforgettable experiences. Whether you're seeking adventure, relaxation, or cultural immersion, the world has endless possibilities to offer.
            </p>
            <h2>The Art of Slow Travel</h2>
            <p>
                In a world obsessed with speed and efficiency, slow travel offers a refreshing alternative. Instead of rushing through a checklist of tourist attractions, slow travel encourages you to take your time, immerse yourself in local culture, and truly connect with the places you visit.
            </p>
            <p>
                Imagine spending a week in a Tuscan village, shopping at local markets, cooking traditional meals, and forming genuine connections with residents. This approach transforms a typical vacation into a life-changing experience.
            </p>
            <h2>Sustainable Tourism</h2>
            <p>
                As responsible travelers, we have the power to make positive impacts on the destinations we visit. Choosing eco-friendly accommodations, supporting local businesses, and respecting local customs are just a few ways to travel sustainably.
            </p>
            <blockquote class="bg-red-50 border-l-4 border-red-500 p-6 rounded-r-xl">
                <p class="text-luxury-700 italic">
                    "Travel is the only thing you buy that makes you richer. The memories, perspectives, and connections you gain are priceless treasures that last a lifetime."
                </p>
            </blockquote>
            <h3>Tips for Your Next Journey</h3>
            <ul>
                <li><strong>Plan but stay flexible:</strong> Have a rough itinerary but leave room for spontaneous discoveries.</li>
                <li><strong>Learn basic phrases:</strong> A few words in the local language can open doors and hearts.</li>
                <li><strong>Travel off-season:</strong> Avoid crowds, save money, and experience destinations like a local.</li>
                <li><strong>Document your journey:</strong> Keep a travel journal to preserve your memories and insights.</li>
            </ul>
            @endif
        </div>

        <!-- Tags -->
        @if($blog->tags)
        <div class="mt-12 pt-8 border-t border-luxury-200">
            <h4 class="text-sm font-semibold text-luxury-500 uppercase tracking-wide mb-4">Tags</h4>
            <div class="flex flex-wrap gap-2">
                @foreach($blog->tags as $tag)
                <span class="px-4 py-2 bg-luxury-100 text-luxury-600 rounded-full text-sm hover:bg-red-100 hover:text-red-700 transition-colors cursor-pointer">
                    #{{ $tag }}
                </span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Share Buttons -->
        <div class="mt-12 pt-8 border-t border-luxury-200">
            <h4 class="text-sm font-semibold text-luxury-500 uppercase tracking-wide mb-4">Share This Article</h4>
            <div class="flex items-center gap-3">
                <a href="#" class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>
                <a href="#" class="w-10 h-10 bg-sky-500 text-white rounded-full flex items-center justify-center hover:bg-sky-600 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                </a>
                <a href="#" class="w-10 h-10 bg-green-500 text-white rounded-full flex items-center justify-center hover:bg-green-600 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                </a>
                <button onclick="navigator.clipboard.writeText(window.location.href)" class="w-10 h-10 bg-luxury-200 text-luxury-600 rounded-full flex items-center justify-center hover:bg-luxury-300 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</article>

<!-- Author Box -->
<section class="py-12 bg-luxury-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-luxury p-8 flex flex-col md:flex-row items-center gap-6">
            <div class="w-24 h-24 bg-gradient-to-br from-red-400 to-red-600 rounded-full flex items-center justify-center flex-shrink-0">
                <span class="text-white font-display text-3xl font-bold">{{ Str::substr($blog->user->name, 0, 1) }}</span>
            </div>
            <div class="text-center md:text-left">
                <p class="text-sm text-red-600 font-semibold uppercase tracking-wide mb-1">Written By</p>
                <h4 class="font-display text-2xl font-bold text-luxury-900 mb-2">{{ $blog->user->name }}</h4>
                <p class="text-luxury-600">Travel enthusiast & luxury lifestyle writer. Passionate about discovering hidden gems and sharing extraordinary experiences with fellow travelers.</p>
            </div>
        </div>
    </div>
</section>

<!-- Related Posts -->
<section class="py-16 px-4">
    <div class="max-w-7xl mx-auto">
        <h2 class="font-display text-3xl font-bold text-luxury-900 mb-8 text-center">You Might Also Like</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
            // Simple related logic: just grab random posts for demo
            $related = \App\Models\Blog::where('id', '!=', $blog->id)->where('is_published', true)->latest()->take(3)->get();
            @endphp
            @foreach($related as $post)
            <a href="{{ route('blog.show', $post->slug) }}" class="group bg-white rounded-2xl shadow-luxury overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="h-40 overflow-hidden">
                    <img src="{{ $post->image
    ? asset('storage/' . $post->image)
    : 'https://images.unsplash.com/photo-1488085061387-422e29b40080?w=600' }}"
     alt="{{ $post->title }}"
     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-5">
                    <span class="text-xs text-red-600 font-medium">{{ $post->category }}</span>
                    <h3 class="font-display text-lg font-semibold text-luxury-900 mt-1 group-hover:text-red-600 transition-colors line-clamp-2">{{ $post->title }}</h3>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
