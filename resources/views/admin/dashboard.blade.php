@extends('layouts.admin')

@section('title', 'Dashboard - Admin')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-display font-bold text-luxury-900">Dashboard</h1>
    <p class="text-luxury-500">Welcome back, {{ auth()->user()->name }}</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 shadow-luxury">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="text-xs text-green-500 font-medium">+12%</span>
        </div>
        <p class="text-luxury-500 text-sm">Total Revenue</p>
        <p class="text-2xl font-display font-bold text-luxury-900">IDR {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-luxury">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <span class="text-xs text-green-500 font-medium">+8%</span>
        </div>
        <p class="text-luxury-500 text-sm">Total Profit</p>
        <p class="text-2xl font-display font-bold text-luxury-900">IDR {{ number_format($totalProfit, 0, ',', '.') }}</p>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-luxury">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>
        <p class="text-luxury-500 text-sm">Total Bookings</p>
        <p class="text-2xl font-display font-bold text-luxury-900">{{ $totalBookings }}</p>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-luxury">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <p class="text-luxury-500 text-sm">Pending Bookings</p>
        <p class="text-2xl font-display font-bold text-luxury-900">{{ $pendingBookings }}</p>
    </div>
</div>

<!-- Recent Bookings -->
<div class="bg-white rounded-2xl shadow-luxury overflow-hidden">
    <div class="p-6 border-b border-luxury-100">
        <h2 class="text-lg font-display font-semibold text-luxury-900">Recent Bookings</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-luxury-50">
                <tr>
                    <th class="text-left px-6 py-4 text-sm font-medium text-luxury-600">Booking Code</th>
                    <th class="text-left px-6 py-4 text-sm font-medium text-luxury-600">Customer</th>
                    <th class="text-left px-6 py-4 text-sm font-medium text-luxury-600">Type</th>
                    <th class="text-left px-6 py-4 text-sm font-medium text-luxury-600">Total</th>
                    <th class="text-left px-6 py-4 text-sm font-medium text-luxury-600">Status</th>
                    <th class="text-left px-6 py-4 text-sm font-medium text-luxury-600">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-luxury-100">
                @foreach($recentBookings as $booking)
                <tr class="hover:bg-luxury-50 transition-colors">
                    <td class="px-6 py-4">
                        <span class="font-mono text-sm text-luxury-900">{{ $booking->booking_code }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <p class="font-medium text-luxury-900">{{ $booking->customer_name }}</p>
                            <p class="text-sm text-luxury-500">{{ $booking->customer_email }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $booking->type === 'package' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' }}">
                            {{ ucfirst($booking->type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-medium text-luxury-900">
                        IDR {{ number_format($booking->total, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-600' : ($booking->status === 'pending' ? 'bg-orange-100 text-orange-600' : 'bg-gray-100 text-gray-600') }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-red-600 hover:text-red-700 font-medium text-sm">
                            View Details
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
