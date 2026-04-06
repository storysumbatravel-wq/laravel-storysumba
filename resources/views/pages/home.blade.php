@extends('layouts.app')

@section('title', 'StorySumba - Premium Travel Agency')
@section('meta_description', 'Experience luxury travel with StorySumba. Premium travel packages, car rentals, and personalized services for discerning travelers.')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-screen flex items-center">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="{{ asset('images/hero1.jpg') }}" alt="Beach" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-luxury-900/90 via-luxury-900/70 to-transparent"></div>
    </div>

    <!-- Content -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
        <div class="max-w-3xl">
            <span class="inline-block px-4 py-2 bg-red-500/20 text-red-400 rounded-full text-sm font-medium mb-6 animate-fade-in">
                ✨ Premium Travel Experience
            </span>
            <h1 class="font-display text-5xl md:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6 animate-slide-up">
                {{ __('messages.hero.title') }}
            </h1>
            <p class="text-xl text-white/80 mb-10 max-w-2xl animate-slide-up" style="animation-delay: 0.2s">
                {{ __('messages.hero.subtitle') }}
            </p>
            <div class="flex flex-wrap gap-4 animate-slide-up" style="animation-delay: 0.4s">
                <a href="{{ route('packages.index') }}" class="px-8 py-4 bg-red-500 text-white rounded-full font-semibold hover:bg-red-600 transition-all duration-300 shadow-red hover:shadow-lg hover:-translate-y-1">
                    {{ __('messages.hero.cta') }}
                </a>
                <a href="{{ route('contact') }}" class="px-8 py-4 bg-white/10 text-white border border-white/30 rounded-full font-semibold hover:bg-white/20 transition-all duration-300 backdrop-blur-sm hover:-translate-y-1">
                    {{ __('messages.hero.secondary') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-float">
        <div class="w-8 h-12 border-2 border-white/50 rounded-full flex justify-center pt-2">
            <div class="w-1 h-3 bg-red-400 rounded-full animate-bounce"></div>
        </div>
    </div>
</section>

<!-- Featured Packages -->
<section class="py-24 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-2 bg-red-100 text-red-600 rounded-full text-sm font-medium mb-4">
                {{ __('messages.packages.title') }}
            </span>
            <h2 class="font-display text-4xl md:text-5xl font-bold text-luxury-900 mb-4">
                {{ __('messages.packages.subtitle') }}
            </h2>
        </div>

        <!-- Packages Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredPackages as $package)

            {{-- Logika Pengambilan Harga --}}
            @php
                $minPrice = 0;
                $showSuffix = false;

                // Cek apakah ada pricing options (harga dinamis per pax)
                if ($package->relationLoaded('pricingOptions') && $package->pricingOptions->isNotEmpty()) {
                    $minPrice = $package->pricingOptions->min('price'); // Ambil harga terendah
                    $showSuffix = true; // Tampilkan "/pax"
                } else {
                    // Fallback ke harga lama (kolom price langsung)
                    $minPrice = $package->discount_price ?? $package->price;
                }
            @endphp

            <div class="group bg-white rounded-2xl shadow-luxury overflow-hidden hover:shadow-xl transition-all duration-500 hover:-translate-y-2">
                <!-- Image -->
                <div class="relative h-64 overflow-hidden">
                    @if($package->image)
                        <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                        @php
                        $images = [
                            'Bali' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800',
                            'Maldives' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=800',
                            'Japan' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?w=800',
                            'Raja Ampat' => 'https://images.unsplash.com/photo-1516690561799-46d8f74f9abf?w=800',
                            'Europe' => 'https://images.unsplash.com/photo-1499856871958-5b9627545d1a?w=800',
                        ];
                        $imageKey = collect($images)->keys()->first(function($key) use ($package) {
                            return str_contains($package->destination_en ?? '', $key);
                        });
                        $imageUrl = $imageKey ? $images[$imageKey] : 'https://images.unsplash.com/photo-1488085061387-422e29b40080?w=800';
                        @endphp
                        <img src="{{ $imageUrl }}" alt="{{ $package->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @endif

                    @if($package->discount_price)
                    <div class="absolute top-4 left-4 px-3 py-1 bg-red-500 text-white text-sm font-medium rounded-full">
                        -{{ $package->discount_percent }}%
                    </div>
                    @endif

                    <div class="absolute top-4 right-4 px-3 py-1 bg-white/90 backdrop-blur-sm text-luxury-700 text-sm font-medium rounded-full capitalize">
                        {{ $package->type }}
                    </div>

                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-4">
                        <span class="text-white/80 text-sm">{{ $package->destination }}</span>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <h3 class="font-display text-xl font-semibold text-luxury-900 mb-2 group-hover:text-red-600 transition-colors">
                        {{ $package->name }}
                    </h3>

                    <div class="flex items-center gap-4 text-sm text-luxury-500 mb-4">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $package->duration_days }} {{ __('messages.packages.days') }} {{ $package->duration_nights }} {{ __('messages.packages.nights') }}
                        </span>
                    </div>

                    <div class="flex items-end justify-between">
                        <div>
                            <span class="text-sm text-luxury-500">{{ __('messages.packages.from') }}</span>
                            <p class="font-display text-2xl font-bold text-red-600">
                                IDR {{ number_format($minPrice, 0, ',', '.') }}
                                @if($showSuffix)
                                    <span class="text-sm font-normal text-luxury-500">/pax</span>
                                @endif
                            </p>

                            {{-- Tampilkan harga coret hanya jika menggunakan harga lama (bukan pricing options) dan ada diskon --}}
                            @if(!$showSuffix && $package->discount_price)
                            <span class="text-sm text-luxury-400 line-through">
                                IDR {{ number_format($package->price, 0, ',', '.') }}
                            </span>
                            @endif
                        </div>
                        <a href="{{ route('packages.show', $package->slug) }}" class="px-4 py-2 bg-luxury-100 text-luxury-700 rounded-lg text-sm font-medium hover:bg-red-500 hover:text-white transition-all">
                            {{ __('messages.packages.view_details') }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- View All Button -->
        <div class="text-center mt-12">
            <a href="{{ route('packages.index') }}" class="inline-flex items-center gap-2 px-8 py-4 border-2 border-red-500 text-red-600 rounded-full font-semibold hover:bg-red-500 hover:text-white transition-all duration-300">
                {{ __('messages.packages.view_all') }}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="py-24 bg-luxury-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Image -->
            <div class="relative">
                <img src="{{ asset('images/40.jpg') }}" alt="Travel" class="rounded-2xl shadow-luxury">
                <div class="absolute -bottom-8 -right-8 bg-red-500 text-white p-6 rounded-2xl shadow-lg hidden md:block">
                    <p class="font-display text-4xl font-bold">15+</p>
                    <p class="text-red-100">Years Experience</p>
                </div>
            </div>

            <!-- Content -->
            <div>
                <span class="inline-block px-4 py-2 bg-red-100 text-red-600 rounded-full text-sm font-medium mb-4">
                    {{ __('messages.about.title') }}
                </span>
                <h2 class="font-display text-4xl md:text-5xl font-bold text-luxury-900 mb-6">
                    {{ __('messages.about.subtitle') }}
                </h2>
                <p class="text-luxury-600 leading-relaxed mb-8">
                    {{ __('messages.about.desc') }}
                </p>

                <!-- Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="text-center p-4 bg-white rounded-xl shadow-luxury">
                        <p class="font-display text-3xl font-bold text-red-600">50K+</p>
                        <p class="text-sm text-luxury-500">{{ __('messages.about.stat1') }}</p>
                    </div>
                    <div class="text-center p-4 bg-white rounded-xl shadow-luxury">
                        <p class="font-display text-3xl font-bold text-red-600">100+</p>
                        <p class="text-sm text-luxury-500">{{ __('messages.about.stat2') }}</p>
                    </div>
                    <div class="text-center p-4 bg-white rounded-xl shadow-luxury">
                        <p class="font-display text-3xl font-bold text-red-600">15+</p>
                        <p class="text-sm text-luxury-500">{{ __('messages.about.stat3') }}</p>
                    </div>
                    <div class="text-center p-4 bg-white rounded-xl shadow-luxury">
                        <p class="font-display text-3xl font-bold text-red-600">25+</p>
                        <p class="text-sm text-luxury-500">{{ __('messages.about.stat4') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Rent Car Section -->
<section class="py-24 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-2 bg-red-100 text-red-600 rounded-full text-sm font-medium mb-4">
                {{ __('messages.rentcar.title') }}
            </span>
            <h2 class="font-display text-4xl md:text-5xl font-bold text-luxury-900 mb-4">
                {{ __('messages.rentcar.subtitle') }}
            </h2>
        </div>

        <!-- Cars Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($rentCars as $car)
            <div class="bg-white rounded-2xl shadow-luxury overflow-hidden group hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <!-- Image -->
                <div class="relative h-48 bg-luxury-100 overflow-hidden">
                    @if($car->image)
                        <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=800" alt="{{ $car->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @endif

                    <div class="absolute top-4 right-4 px-3 py-1 {{ $car->status === 'available' ? 'bg-green-500' : ($car->status === 'rented' ? 'bg-orange-500' : 'bg-gray-500') }} text-white text-xs font-medium rounded-full">
                        {{ __('messages.rentcar.' . $car->status) }}
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <h3 class="font-display text-xl font-semibold text-luxury-900 mb-2">{{ $car->name }}</h3>
                    <p class="text-sm text-luxury-500 mb-4">{{ $car->brand }} {{ $car->model }} • {{ $car->year }}</p>

                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-2 py-1 bg-luxury-100 text-luxury-600 text-xs rounded-full">
                            {{ $car->seats }} {{ __('messages.rentcar.seats') }}
                        </span>
                        <span class="px-2 py-1 bg-luxury-100 text-luxury-600 text-xs rounded-full">
                            {{ __('messages.rentcar.' . $car->transmission) }}
                        </span>
                        @if($car->with_driver)
                        <span class="px-2 py-1 bg-red-100 text-red-600 text-xs rounded-full">
                            {{ __('messages.rentcar.with_driver') }}
                        </span>
                        @endif
                    </div>

                    <div class="flex items-end justify-between pt-4 border-t border-luxury-100">
                        <div>
                            <span class="text-sm text-luxury-500">Price</span>
                            <p class="font-display text-xl font-bold text-red-600">
                                IDR {{ number_format($car->price_per_day, 0, ',', '.') }}
                                <span class="text-sm font-normal text-luxury-500">{{ __('messages.rentcar.per_day') }}</span>
                            </p>
                        </div>
                        <a href="{{ route('rentcar.show', $car->id) }}" class="px-4 py-2 bg-red-500 text-white rounded-lg text-sm font-medium hover:bg-red-600 transition-all">
                            {{ __('messages.rentcar.book') }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- View All Button -->
        <div class="text-center mt-12">
            <a href="{{ route('rentcar.index') }}" class="inline-flex items-center gap-2 px-8 py-4 border-2 border-red-500 text-red-600 rounded-full font-semibold hover:bg-red-500 hover:text-white transition-all duration-300">
                {{ __('messages.common.view_all') }}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Blog Section -->
<section class="py-24 bg-luxury-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-2 bg-red-100 text-red-600 rounded-full text-sm font-medium mb-4">
                {{ __('messages.blog.title') }}
            </span>
            <h2 class="font-display text-4xl md:text-5xl font-bold text-luxury-900 mb-4">
                {{ __('messages.blog.subtitle') }}
            </h2>
        </div>

        <!-- Blog Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($blogs as $blog)
            <article class="bg-white rounded-2xl shadow-luxury overflow-hidden group hover:shadow-xl transition-all duration-300">
                <!-- Image -->
                <div class="relative h-48 overflow-hidden">
                    @if($blog->image)
                        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <img src="https://images.unsplash.com/photo-1488085061387-422e29b40080?w=800" alt="{{ $blog->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @endif

                    <div class="absolute top-4 left-4 px-3 py-1 bg-red-500 text-white text-xs font-medium rounded-full">
                        {{ $blog->category }}
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <h3 class="font-display text-xl font-semibold text-luxury-900 mb-3 group-hover:text-red-600 transition-colors line-clamp-2">
                        {{ $blog->title }}
                    </h3>
                    <p class="text-luxury-500 text-sm mb-4 line-clamp-2">
                        {{ $blog->excerpt }}
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-luxury-400">
                            {{ $blog->published_at?->format('M d, Y') }}
                        </span>
                        <a href="{{ route('blog.show', $blog->slug) }}" class="text-red-600 text-sm font-medium hover:text-red-700 transition-colors flex items-center gap-1">
                            {{ __('messages.blog.read_more') }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-24 px-4">
    <div class="max-w-5xl mx-auto">
        <div class="relative bg-gradient-to-br from-luxury-900 to-luxury-800 rounded-3xl overflow-hidden">
            <div class="absolute inset-0 opacity-20">
                <img src="{{ asset('images/gallery-3.jpg') }}" alt="Background" class="w-full h-full object-cover">
            </div>
            <div class="relative p-12 md:p-16 text-center">
                <h2 class="font-display text-4xl md:text-5xl font-bold text-white mb-4">
                    Ready for Your Next Adventure?
                </h2>
                <p class="text-white/80 text-lg mb-8 max-w-2xl mx-auto">
                    Let us create your perfect travel experience. Contact our travel experts today and start planning your dream vacation.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('contact') }}" class="px-8 py-4 bg-red-500 text-white rounded-full font-semibold hover:bg-red-600 transition-all duration-300 shadow-red hover:shadow-lg hover:-translate-y-1">
                        Contact Us
                    </a>
                    <a href="tel:+622112345678" class="px-8 py-4 bg-white/10 text-white border border-white/30 rounded-full font-semibold hover:bg-white/20 transition-all duration-300 backdrop-blur-sm hover:-translate-y-1 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        +62 812 4699 4982
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
