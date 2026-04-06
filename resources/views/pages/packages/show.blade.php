@extends('layouts.app')

@section('title', (app()->getLocale() === 'id' ? $package->name_id : $package->name_en) . ' - StorySumba')
@section('meta_description', app()->getLocale() === 'id' ? $package->description_id : $package->description_en)

@section('content')
<section class="relative pt-32 pb-20">
    <div class="absolute inset-0">
        <img src="{{ $package->image ? asset('storage/' . $package->image) : 'https://images.unsplash.com/photo-1488085061387-422e29b40080?w=1920' }}" alt="{{ $package->name_en }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-luxury-900/95 via-luxury-900/80 to-transparent"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <div class="flex items-center gap-3 mb-4">
                <span class="px-3 py-1 bg-red-500 text-white text-sm font-medium rounded-full capitalize">{{ $package->type }}</span>
            </div>
            <h1 class="font-display text-5xl md:text-6xl font-bold text-white mb-4">{{ app()->getLocale() === 'id' ? $package->name_id : $package->name_en }}</h1>
            <p class="text-xl text-white/80 mb-6">{{ app()->getLocale() === 'id' ? $package->destination_id : $package->destination_en }}</p>
        </div>
    </div>
</section>

<section class="py-16 px-4">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-12">
        <div class="lg:col-span-2 space-y-12">

            <!-- Description -->
            <div>
                <h2 class="font-display text-2xl font-bold text-luxury-900 mb-4">Overview</h2>
                <p class="text-luxury-600 leading-relaxed text-lg">{{ app()->getLocale() === 'id' ? $package->description_id : $package->description_en }}</p>
            </div>

            <!-- Highlights -->
            @php $highlights = app()->getLocale() === 'id' ? $package->highlights_id : $package->highlights_en; @endphp
            @if(!empty($highlights))
            <div>
                <h2 class="font-display text-2xl font-bold text-luxury-900 mb-6">Highlights</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($highlights as $highlight)
                    <div class="flex items-start gap-3 p-4 bg-red-50 rounded-xl">
                        <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-luxury-700">{{ $highlight }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- ITINERARY SECTION -->
            @php
                $itinerary = app()->getLocale() === 'id' ? $package->itinerary_id : $package->itinerary_en;
            @endphp
            @if(!empty($itinerary))
            <div>
                <h2 class="font-display text-2xl font-bold text-luxury-900 mb-6">Itinerary</h2>
                <div class="space-y-4">
                    @if(is_array($itinerary))
                        @foreach($itinerary as $key => $item)
                        <div class="bg-white border border-luxury-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                            <h3 class="font-semibold text-lg text-red-600 mb-2">Day {{ $key + 1 }}</h3>
                            @if(is_array($item))
                                @if(isset($item['title']))
                                    <h4 class="font-semibold text-luxury-800 mb-1">{{ $item['title'] }}</h4>
                                @endif
                                @if(isset($item['description']))
                                    <div class="text-luxury-600">{!! $item['description'] !!}</div>
                                @else
                                    <ul class="list-disc list-inside text-luxury-600 space-y-1">
                                        @foreach($item as $subItem)
                                            <li>{{ $subItem }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            @else
                                <p class="text-luxury-600">{!! $item !!}</p>
                            @endif
                        </div>
                        @endforeach
                    @else
                        <div class="prose max-w-none text-luxury-600">
                            {!! $itinerary !!}
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- INCLUDE & EXCLUDE SECTION -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Include -->
                @php
                    $includes = app()->getLocale() === 'id' ? $package->include_id : $package->include_en;
                @endphp
                @if(!empty($includes))
                <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                    <h3 class="font-semibold text-lg text-green-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Include
                    </h3>
                    <ul class="space-y-2">
                        @if(is_array($includes))
                            @foreach($includes as $inc)
                            <li class="flex items-start gap-2 text-green-700">
                                <span class="text-green-500 mt-1">•</span>
                                <span>{{ $inc }}</span>
                            </li>
                            @endforeach
                        @else
                            <li class="text-green-700">{!! $includes !!}</li>
                        @endif
                    </ul>
                </div>
                @endif

                <!-- Exclude -->
                @php
                    $excludes = app()->getLocale() === 'id' ? $package->exclude_id : $package->exclude_en;
                @endphp
                @if(!empty($excludes))
                <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                    <h3 class="font-semibold text-lg text-red-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Exclude
                    </h3>
                    <ul class="space-y-2">
                        @if(is_array($excludes))
                            @foreach($excludes as $exc)
                            <li class="flex items-start gap-2 text-red-700">
                                <span class="text-red-500 mt-1">•</span>
                                <span>{{ $exc }}</span>
                            </li>
                            @endforeach
                        @else
                            <li class="text-red-700">{!! $excludes !!}</li>
                        @endif
                    </ul>
                </div>
                @endif
            </div>

        </div>

        <!-- BOOKING SIDEBAR -->
        <div class="lg:col-span-1">
            <div class="sticky top-28 bg-white rounded-2xl shadow-luxury overflow-hidden">
                <div class="p-6 border-b border-luxury-100">
                    <div class="flex items-baseline gap-2 mb-2">
                        <span class="text-sm text-luxury-500">Start from</span>
                    </div>
                    @php
                        $firstOption = $package->pricingOptions->sortBy('price')->first();
                        $fromPrice = $firstOption ? $firstOption->price : ($package->price ?? 0);
                    @endphp

                    <p class="font-display text-4xl font-bold text-red-600">
                        IDR {{ number_format($fromPrice, 0, ',', '.') }}
                    </p>
                    <p class="text-sm text-luxury-500 mt-1">per person</p>
                </div>

                <!-- Flash Message untuk Sukses/Error -->
<div class="mb-4">
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Validasi Error Form -->
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl mb-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700 font-medium">Please fix the following errors:</p>
                    <ul class="mt-1 text-sm text-red-600 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
</div>

                <form action="{{ route('booking.store') }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    <input type="hidden" name="package_id" value="{{ $package->id }}">
                    <input type="hidden" name="type" value="package">

                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Full Name</label>
                        <input type="text" name="customer_name" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Email</label>
                        <input type="email" name="customer_email" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Phone Number</label>
                        <input type="tel" name="customer_phone" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Start Date</label>
                        <input type="date" name="start_date" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all">
                    </div>

                    <!-- Pax Dropdown -->
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Number of Pax</label>
                        <select name="pax" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 transition-all">
                            @if($package->pricingOptions->count() > 0)
                                @foreach($package->pricingOptions as $option)
                                    <option value="{{ $option->pax }}">
                                        {{ $option->pax }} Pax - IDR {{ number_format($option->price, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            @else
                                <option value="1">1 Pax</option>
                            @endif
                        </select>
                    </div>

                    <button type="submit" class="w-full py-4 bg-red-500 text-white rounded-xl font-semibold hover:bg-red-600 transition-all shadow-red hover:shadow-lg hover:-translate-y-0.5">
                        Book Now
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
