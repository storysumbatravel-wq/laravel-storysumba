@extends('layouts.app')

@section('title', 'Premium Car Rental - StorySumba')
@section('meta_description', 'Rent luxury and premium cars for your travel needs. Wide selection of well-maintained vehicles with professional driver options.')

@section('content')
<!-- Hero Section -->
<section class="relative pt-32 pb-20">
    <div class="absolute inset-0">
        <img src="{{ asset('images/rent-car.jpg') }}" alt="Car Rental" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-luxury-900/90 via-luxury-900/80 to-luxury-900/60"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block px-4 py-2 bg-red-500/20 text-red-400 rounded-full text-sm font-medium mb-6">
            Premium Fleet
        </span>
        <h1 class="font-display text-5xl md:text-6xl font-bold text-white mb-6">
            {{ __('messages.rentcar.title') }}
        </h1>
        <p class="text-xl text-white/80 max-w-2xl mx-auto">
            {{ __('messages.rentcar.subtitle') }}
        </p>
    </div>
</section>

<!-- Filter Section -->
<section class="py-8 bg-white border-b border-luxury-100 sticky top-20 z-20 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('rentcar.index') }}" class="flex flex-wrap items-center gap-4">
            <!-- Brand Filter -->
            <div class="w-48">
                <select name="brand" class="w-full px-4 py-2.5 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all appearance-none cursor-pointer">
                    <option value="">All Brands</option>
                    @foreach($brands as $brand)
                    <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Transmission Filter -->
            <div class="w-48">
                <select name="transmission" class="w-full px-4 py-2.5 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all appearance-none cursor-pointer">
                    <option value="">All Transmission</option>
                    <option value="automatic" {{ request('transmission') == 'automatic' ? 'selected' : '' }}>{{ __('messages.rentcar.automatic') }}</option>
                    <option value="manual" {{ request('transmission') == 'manual' ? 'selected' : '' }}>{{ __('messages.rentcar.manual') }}</option>
                </select>
            </div>

            <!-- Status Filter -->
            <div class="w-48">
                <select name="status" class="w-full px-4 py-2.5 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all appearance-none cursor-pointer">
                    <option value="">All Status</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>{{ __('messages.rentcar.available') }}</option>
                    <option value="rented" {{ request('status') == 'rented' ? 'selected' : '' }}>{{ __('messages.rentcar.rented') }}</option>
                </select>
            </div>

            <button type="submit" class="px-6 py-2.5 bg-red-500 text-white rounded-xl font-medium hover:bg-red-600 transition-colors">
                Filter
            </button>

            @if(request()->has('brand') || request()->has('transmission') || request()->has('status'))
            <a href="{{ route('rentcar.index') }}" class="text-luxury-500 hover:text-red-500 transition-colors text-sm flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                Clear
            </a>
            @endif
        </form>
    </div>
</section>

<!-- Cars Grid -->
<section class="py-16 px-4">
    <div class="max-w-7xl mx-auto">
        @if($cars->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($cars as $car)
            <div class="bg-white rounded-2xl shadow-luxury overflow-hidden group hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <!-- Image -->
                <div class="relative h-56 bg-luxury-100 overflow-hidden">
                    {{-- PERBAIKAN: Logika gambar diubah --}}
                    <img src="{{ $car->image
                        ? asset('storage/' . $car->image)
                        : 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=800' }}"
                         alt="{{ $car->name }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                    <!-- Status Badge -->
                    <div class="absolute top-4 right-4 px-3 py-1 {{ $car->status === 'available' ? 'bg-green-500' : ($car->status === 'rented' ? 'bg-orange-500' : 'bg-gray-500') }} text-white text-xs font-medium rounded-full">
                        {{ __('messages.rentcar.' . $car->status) }}
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="font-display text-xl font-semibold text-luxury-900 group-hover:text-red-600 transition-colors">
                                {{ $car->name }}
                            </h3>
                            <p class="text-sm text-luxury-500">{{ $car->brand }} {{ $car->model }} • {{ $car->year }}</p>
                        </div>
                    </div>

                    <!-- Specs -->
                    <div class="flex flex-wrap gap-2 mb-5">
                        <span class="flex items-center gap-1.5 px-3 py-1.5 bg-luxury-50 text-luxury-600 text-xs rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            {{ $car->seats }} {{ __('messages.rentcar.seats') }}
                        </span>
                        <span class="flex items-center gap-1.5 px-3 py-1.5 bg-luxury-50 text-luxury-600 text-xs rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                            </svg>
                            {{ __('messages.rentcar.' . $car->transmission) }}
                        </span>
                        @if($car->with_driver)
                        <span class="flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-600 text-xs rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            + Driver
                        </span>
                        @endif
                    </div>

                    <!-- Price -->
                    <div class="flex items-end justify-between pt-4 border-t border-luxury-100">
                        <div>
                            <span class="text-xs text-luxury-500 uppercase">Per Day</span>
                            <p class="font-display text-xl font-bold text-red-600">
                                IDR {{ number_format($car->price_per_day, 0, ',', '.') }}
                            </p>
                        </div>
                        <a href="{{ route('rentcar.show', $car->id) }}" class="px-5 py-2.5 {{ $car->status === 'available' ? 'bg-red-500 hover:bg-red-600 text-white' : 'bg-luxury-200 text-luxury-400 cursor-not-allowed' }} rounded-lg text-sm font-medium transition-all">
                            {{ $car->status === 'available' ? __('messages.rentcar.book') : 'View Details' }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            {{ $cars->appends(request()->query())->links() }}
        </div>
        @else
        <div class="text-center py-20">
            <svg class="w-24 h-24 text-luxury-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
            </svg>
            <h3 class="text-xl font-display font-semibold text-luxury-700 mb-2">No cars found</h3>
            <p class="text-luxury-500">Try adjusting your filters to find available vehicles.</p>
        </div>
        @endif
    </div>
</section>
@endsection
