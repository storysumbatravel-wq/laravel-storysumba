@extends('layouts.admin')

@section('title', 'Booking Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center gap-2 text-luxury-600 hover:text-red-600 transition-colors text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Bookings
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column: Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Customer Info -->
        <div class="bg-white rounded-2xl shadow-luxury p-8">
            <h2 class="text-lg font-semibold text-luxury-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Customer Information
            </h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-luxury-400 uppercase font-semibold">Name</p>
                    <p class="text-luxury-900 font-medium">{{ $booking->customer_name }}</p>
                </div>
                <div>
                    <p class="text-xs text-luxury-400 uppercase font-semibold">Phone</p>
                    <p class="text-luxury-900 font-medium">{{ $booking->customer_phone }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-xs text-luxury-400 uppercase font-semibold">Email</p>
                    <p class="text-luxury-900 font-medium">{{ $booking->customer_email }}</p>
                </div>
            </div>
        </div>

        <!-- Booking Details -->
        <div class="bg-white rounded-2xl shadow-luxury p-8">
            <h2 class="text-lg font-semibold text-luxury-900 mb-4">Booking Details</h2>

            <div class="flex items-center gap-4 p-4 bg-luxury-50 rounded-xl mb-6">
                <div class="w-16 h-16 bg-white rounded-lg overflow-hidden shadow-sm flex-shrink-0">
                    @if($booking->type === 'package' && $booking->package?->image)
                        <img src="{{ asset('storage/' . $booking->package->image) }}" class="w-full h-full object-cover">
                    @elseif($booking->type === 'rentcar' && $booking->rentCar?->image)
                        <img src="{{ asset('storage/' . $booking->rentCar->image) }}" class="w-full h-full object-cover">
                    @else
                         <img src="https://via.placeholder.com/100" class="w-full h-full object-cover">
                    @endif
                </div>
                <div>
                    <span class="text-xs font-semibold uppercase {{ $booking->type === 'package' ? 'text-blue-600' : 'text-green-600' }}">{{ $booking->type }}</span>
                    <h3 class="font-bold text-luxury-900">
                        @if($booking->type === 'package')
                            {{ $booking->package?->name ?? 'N/A' }}
                        @else
                            {{ $booking->rentCar?->name ?? 'N/A' }}
                        @endif
                    </h3>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-luxury-500">Start Date</p>
                    {{-- Gunakan ?-> atau optional() untuk mencegah error jika null --}}
                    <p class="font-semibold text-luxury-900">{{ $booking->start_date?->format('F d, Y') ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-luxury-500">End Date</p>
                    {{-- Perbaikan pada baris 75 --}}
                    <p class="font-semibold text-luxury-900">{{ $booking->end_date?->format('F d, Y') ?? '-' }}</p>
                </div>
                @if($booking->persons)
                <div>
                    <p class="text-luxury-500">Persons</p>
                    <p class="font-semibold text-luxury-900">{{ $booking->persons }} Pax</p>
                </div>
                @endif
                @if($booking->with_driver)
                <div>
                    <p class="text-luxury-500">Driver Option</p>
                    <p class="font-semibold text-green-600">Included</p>
                </div>
                @endif
            </div>

            @if($booking->message)
            <div class="mt-4 pt-4 border-t border-luxury-100">
                <p class="text-luxury-500 text-sm">Message/Notes:</p>
                <p class="text-luxury-700 bg-yellow-50 p-3 rounded-lg text-sm italic">{{ $booking->message }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Right Column: Actions -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-luxury p-8 sticky top-28">
            <h2 class="text-lg font-semibold text-luxury-900 mb-4">Update Status</h2>

            <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST">
                @csrf @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-luxury-700 mb-2">Current Status</label>
                    <select name="status" class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl">
                        <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <button type="submit" class="w-full py-3 bg-red-500 text-white rounded-xl font-semibold hover:bg-red-600 transition-colors">
                    Save Changes
                </button>
            </form>

            <hr class="my-6 border-luxury-100">

            <div class="text-center text-sm text-luxury-500">
                <p>Booking ID: #{{ $booking->id }}</p>
                <p>Created: {{ $booking->created_at->diffForHumans() }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
