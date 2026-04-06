@extends('layouts.admin')

@section('title', 'Vehicle Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.rent-cars.index') }}" class="inline-flex items-center gap-2 text-luxury-600 hover:text-red-600 transition-colors text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to List
    </a>
</div>

<div class="bg-white rounded-2xl shadow-luxury overflow-hidden">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
        <!-- Image Section -->
        <div class="h-64 lg:h-auto bg-luxury-100">
            @if($rentCar->image)
                <img src="{{ asset('storage/' . $rentCar->image) }}" alt="{{ $rentCar->name }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-luxury-400">
                    No Image Available
                </div>
            @endif
        </div>

        <!-- Details Section -->
        <div class="p-8">
            <div class="flex items-center gap-3 mb-4">
                <span class="px-3 py-1 rounded-full text-xs font-semibold uppercase {{
                    $rentCar->status == 'available' ? 'bg-green-100 text-green-600' :
                    ($rentCar->status == 'rented' ? 'bg-blue-100 text-blue-600' : 'bg-yellow-100 text-yellow-600')
                }}">
                    {{ $rentCar->status }}
                </span>
                @if($rentCar->with_driver)
                    <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-semibold uppercase">With Driver</span>
                @endif
            </div>

            <h1 class="text-3xl font-display font-bold text-luxury-900 mb-1">{{ $rentCar->name }}</h1>
            <p class="text-luxury-500 mb-6">{{ $rentCar->brand }} {{ $rentCar->model }} ({{ $rentCar->year }})</p>

            <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                <div class="bg-luxury-50 p-4 rounded-xl">
                    <p class="text-luxury-500">Transmission</p>
                    <p class="font-semibold text-luxury-900 capitalize">{{ $rentCar->transmission }}</p>
                </div>
                <div class="bg-luxury-50 p-4 rounded-xl">
                    <p class="text-luxury-500">Fuel Type</p>
                    <p class="font-semibold text-luxury-900 capitalize">{{ $rentCar->fuel_type }}</p>
                </div>
                <div class="bg-luxury-50 p-4 rounded-xl">
                    <p class="text-luxury-500">Seats</p>
                    <p class="font-semibold text-luxury-900">{{ $rentCar->seats }} Persons</p>
                </div>
                <div class="bg-luxury-50 p-4 rounded-xl">
                    <p class="text-luxury-500">Plate Number</p>
                    <p class="font-semibold text-luxury-900 uppercase">{{ $rentCar->plate_number }}</p>
                </div>
            </div>

            <!-- Pricing -->
            <div class="border-t border-luxury-100 pt-6">
                <h3 class="text-lg font-semibold text-luxury-900 mb-3">Pricing</h3>
                <div class="flex items-baseline gap-2 mb-2">
                    <span class="text-2xl font-bold text-red-600">Rp {{ number_format($rentCar->price_per_day) }}</span>
                    <span class="text-luxury-500">/ day</span>
                </div>
                @if($rentCar->price_per_week)
                    <p class="text-sm text-luxury-600">Weekly: Rp {{ number_format($rentCar->price_per_week) }}</p>
                @endif
                @if($rentCar->driver_price_per_day)
                    <p class="text-sm text-luxury-600 mt-2">+ Driver: Rp {{ number_format($rentCar->driver_price_per_day) }} / day</p>
                @endif
            </div>

            <div class="mt-8 flex gap-3">
                <a href="{{ route('admin.rent-cars.edit', $rentCar->id) }}" class="px-6 py-3 bg-red-500 text-white rounded-xl font-medium hover:bg-red-600 transition-colors">
                    Edit Vehicle
                </a>
                <form action="{{ route('admin.rent-cars.destroy', $rentCar->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-6 py-3 bg-red-100 text-red-600 rounded-xl font-medium hover:bg-red-200 transition-colors">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
