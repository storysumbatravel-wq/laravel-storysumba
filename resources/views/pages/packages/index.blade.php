@extends('layouts.app')

@section('title', 'Travel Packages - StorySumba')
@section('meta_description', 'Explore our exclusive travel packages. From luxury honeymoons to adventure trips, find your perfect journey.')

@section('content')
<!-- Hero Section -->
<section class="relative pt-32 pb-20">
    <div class="absolute inset-0">
        <img src="{{ asset('images/blog-1.jpg') }}" alt="Travel" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-luxury-900/90 via-luxury-900/80 to-luxury-900/60"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block px-4 py-2 bg-red-500/20 text-red-400 rounded-full text-sm font-medium mb-6">
            Explore The World
        </span>
        <h1 class="font-display text-5xl md:text-6xl font-bold text-white mb-6">
            {{ __('messages.packages.title') }}
        </h1>
        <p class="text-xl text-white/80 max-w-2xl mx-auto">
            {{ __('messages.packages.subtitle') }}
        </p>
    </div>
</section>

<!-- Filter Section -->
<section class="py-8 bg-white border-b border-luxury-100 sticky top-20 z-20 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('packages.index') }}" class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="destination" value="{{ request('destination') }}" placeholder="Search destination..." class="w-full px-4 py-2.5 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all">
            </div>

            <div class="w-48">
                <select name="type" class="w-full px-4 py-2.5 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all appearance-none cursor-pointer">
                    <option value="">All Types</option>
                    @foreach(['tour', 'adventure', 'luxury'] as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="px-6 py-2.5 bg-red-500 text-white rounded-xl font-medium hover:bg-red-600 transition-colors">
                Filter
            </button>

            @if(request()->has('type') || request()->has('destination'))
            <a href="{{ route('packages.index') }}" class="text-luxury-500 hover:text-red-500 transition-colors text-sm flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                Clear
            </a>
            @endif
        </form>
    </div>
</section>

<!-- Packages Grid -->
<section class="py-16 px-4">
    <div class="max-w-7xl mx-auto">
        @if($packages->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($packages as $package)
            <div class="group bg-white rounded-2xl shadow-luxury overflow-hidden hover:shadow-xl transition-all duration-500 hover:-translate-y-2">
                <div class="relative h-64 overflow-hidden">
                    @php
                        $locale = app()->getLocale();
                        $name = $locale === 'id' ? $package->name_id : $package->name_en;
                        $destination = $locale === 'id' ? $package->destination_id : $package->destination_en;

                        // Ambil harga minimum dari pricing options
                        $firstOption = $package->pricingOptions->sortBy('price')->first();
                        $price = $firstOption ? $firstOption->price : 0;
                    @endphp
                    <img src="{{ $package->image ? asset('storage/' . $package->image) : 'https://images.unsplash.com/photo-1488085061387-422e29b40080?w=800' }}" alt="{{ $name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">

                    <div class="absolute top-4 right-4 px-3 py-1 bg-white/90 backdrop-blur-sm text-luxury-700 text-sm font-medium rounded-full capitalize">
                        {{ $package->type }}
                    </div>

                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-4">
                        <span class="text-white/80 text-sm">{{ $destination }}</span>
                    </div>
                </div>

                <div class="p-6">
                    <h3 class="font-display text-xl font-semibold text-luxury-900 mb-2 group-hover:text-red-600 transition-colors">
                        {{ $name }}
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
                                IDR {{ number_format($price, 0, ',', '.') }}
                            </p>
                        </div>
                        <a href="{{ route('packages.show', $package->slug) }}" class="px-4 py-2 bg-luxury-100 text-luxury-700 rounded-lg text-sm font-medium hover:bg-red-500 hover:text-white transition-all">
                            {{ __('messages.packages.view_details') }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-12 flex justify-center">
            {{ $packages->appends(request()->query())->links() }}
        </div>
        @else
        <div class="text-center py-20">
            <h3 class="text-xl font-display font-semibold text-luxury-700 mb-2">No packages found</h3>
            <p class="text-luxury-500">Try adjusting your search or filter to find what you're looking for.</p>
        </div>
        @endif
    </div>
</section>
@endsection
