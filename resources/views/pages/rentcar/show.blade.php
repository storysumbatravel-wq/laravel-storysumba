@extends('layouts.app')

@section('title', $rentCar->name . ' - Rent Car - StorySumba')
@section('meta_description', 'Rent ' . $rentCar->name . ' for your trip in Sumba.')

@section('content')
@if (session('success'))
    <div class="max-w-7xl mx-auto px-4 mt-6">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    </div>
@endif

<!-- ALERT ERROR VALIDASI -->
@if ($errors->any())
    <div class="max-w-7xl mx-auto px-4 mt-6">
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700 font-medium">
                        Please fix the following errors:
                    </p>
                    <ul class="mt-1 text-sm text-red-600 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif


<!-- HERO SECTION -->
<section class="relative pt-32 pb-20 bg-gradient-to-r from-luxury-900 to-luxury-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white">

        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-white/60 text-sm mb-6">
            <a href="{{ route('home') }}" class="hover:text-red-400 transition">Home</a>
            <span>/</span>
            <a href="{{ route('rentcar.index') }}" class="hover:text-red-400 transition">Rent Car</a>
            <span>/</span>
            <span class="text-white">{{ $rentCar->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Car Info -->
            <div>
                <span class="inline-block px-3 py-1 bg-red-500/20 text-red-400 rounded-full text-sm font-medium mb-4 uppercase">
                    {{ $rentCar->status }}
                </span>
                <h1 class="font-display text-4xl md:text-5xl font-bold mb-4">
                    {{ $rentCar->brand }} {{ $rentCar->name }}
                </h1>
                <p class="text-lg text-white/70 mb-2">
                    {{ $rentCar->year }} • {{ $rentCar->transmission }} • {{ $rentCar->seats }} Seats
                </p>

                <div class="flex items-baseline gap-2 mt-6">
                    <span class="text-4xl font-bold text-red-400">IDR {{ number_format($rentCar->price_per_day, 0, ',', '.') }}</span>
                    <span class="text-white/50">/ day</span>
                </div>

                @if($rentCar->with_driver)
                <p class="text-sm text-green-300 mt-2">
                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Available with Driver (+ IDR {{ number_format($rentCar->driver_price_per_day, 0, ',', '.') }}/day)
                </p>
                @endif
            </div>

            <!-- Car Image -->
            <div class="relative">
                <div class="absolute -inset-4 bg-gradient-to-r from-red-500/20 to-luxury-600/20 rounded-3xl blur-2xl opacity-30"></div>
                <img src="{{ $rentCar->image ? asset('storage/' . $rentCar->image) : 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=800' }}"
                     alt="{{ $rentCar->name }}"
                     class="relative rounded-3xl shadow-2xl w-full h-96 object-cover">
            </div>
        </div>
    </div>
</section>

<!-- DETAILS & BOOKING FORM -->
<section class="py-16 px-4 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            <!-- CAR DETAILS (Left Column) -->
            <div class="lg:col-span-2 space-y-8">

                <!-- Specifications -->
                <div class="bg-luxury-50 rounded-3xl p-8">
                    <h2 class="font-display text-2xl font-bold text-luxury-900 mb-6">Vehicle Specifications</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                        <div>
                            <p class="text-sm text-luxury-500">Brand</p>
                            <p class="font-bold text-luxury-900">{{ $rentCar->brand }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-luxury-500">Model</p>
                            <p class="font-bold text-luxury-900">{{ $rentCar->model }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-luxury-500">Year</p>
                            <p class="font-bold text-luxury-900">{{ $rentCar->year }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-luxury-500">Transmission</p>
                            <p class="font-bold text-luxury-900">{{ ucfirst($rentCar->transmission) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-luxury-500">Fuel Type</p>
                            <p class="font-bold text-luxury-900">{{ ucfirst($rentCar->fuel_type) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-luxury-500">Plate Number</p>
                            <p class="font-bold text-luxury-900">{{ $rentCar->plate_number }}</p>
                        </div>
                    </div>
                </div>

                <!-- Pricing Details -->
                <div class="bg-white border border-luxury-100 rounded-3xl p-8">
                     <h2 class="font-display text-2xl font-bold text-luxury-900 mb-6">Rental Rates</h2>
                     <div class="space-y-4">
                         <div class="flex justify-between items-center pb-3 border-b border-luxury-50">
                             <span class="text-luxury-600">Daily Rate</span>
                             <span class="font-bold text-luxury-900">IDR {{ number_format($rentCar->price_per_day, 0, ',', '.') }}</span>
                         </div>
                         @if($rentCar->price_per_week)
                         <div class="flex justify-between items-center pb-3 border-b border-luxury-50">
                             <span class="text-luxury-600">Weekly Rate (7 Days)</span>
                             <span class="font-bold text-luxury-900">IDR {{ number_format($rentCar->price_per_week, 0, ',', '.') }}</span>
                         </div>
                         @endif
                         @if($rentCar->price_per_month)
                         <div class="flex justify-between items-center">
                             <span class="text-luxury-600">Monthly Rate (30 Days)</span>
                             <span class="font-bold text-luxury-900">IDR {{ number_format($rentCar->price_per_month, 0, ',', '.') }}</span>
                         </div>
                         @endif
                     </div>
                </div>
            </div>

            <!-- BOOKING FORM (Right Column) -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-luxury border border-luxury-100 p-8 sticky top-24">
                    <h3 class="font-display text-xl font-bold text-luxury-900 mb-6">Book This Vehicle</h3>

                    <form action="{{ route('booking.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="car">
                        <input type="hidden" name="rent_car_id" value="{{ $rentCar->id }}">

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-luxury-700 mb-1">Name *</label>
                                <input type="text" name="customer_name" required
                                       class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-luxury-700 mb-1">Email *</label>
                                <input type="email" name="customer_email" required
                                       class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-luxury-700 mb-1">Phone / WhatsApp *</label>
                                <input type="tel" name="customer_phone" required
                                       class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-luxury-700 mb-1">Start Date *</label>
                                <input type="date" name="start_date" required
                                       class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-luxury-700 mb-1">End Date *</label>
                                <input type="date" name="end_date" required
                                       class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500">
                            </div>

                            @if($rentCar->with_driver)
                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="with_driver" id="with_driver"
                                value="1"
                                class="w-4 h-4 text-red-600 border-luxury-300 rounded">
                                <label for="with_driver" class="text-sm text-luxury-700">Include Driver</label>
                            </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-luxury-700 mb-1">Notes</label>
                                <textarea name="notes" rows="3"
                                          class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 resize-none"
                                          placeholder="Pickup location, special requests..."></textarea>
                            </div>
                        </div>

                        <button type="submit" class="w-full mt-6 px-6 py-3 bg-red-500 text-white rounded-xl font-semibold hover:bg-red-600 transition-colors">
                            Send Booking Request
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
