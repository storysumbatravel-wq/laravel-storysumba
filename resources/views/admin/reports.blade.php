@extends('layouts.admin')

@section('title', 'Financial Reports')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-display font-bold text-luxury-900">Financial Reports</h1>
    <p class="text-luxury-500 mt-1">Overview of revenue and profit based on bookings.</p>
</div>

<!-- Filter Section -->
<div class="bg-white rounded-2xl shadow-luxury p-6 mb-8">
    <form method="GET" action="{{ route('admin.reports') }}" class="flex flex-wrap items-end gap-4">
        <div>
            <label class="block text-sm font-medium text-luxury-700 mb-2">Start Date</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}"
                   class="px-4 py-2.5 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-luxury-700 mb-2">End Date</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}"
                   class="px-4 py-2.5 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500">
        </div>

        <button type="submit" class="px-6 py-2.5 bg-red-500 text-white rounded-xl font-medium hover:bg-red-600 transition-colors">
            Apply Filter
        </button>

        @if(request('start_date') || request('end_date'))
        <a href="{{ route('admin.reports') }}" class="px-6 py-2.5 bg-luxury-200 text-luxury-700 rounded-xl font-medium hover:bg-luxury-300 transition-colors">
            Reset
        </a>
        @endif

        <a href="{{ route('admin.reports.export', request()->query()) }}" class="px-6 py-2.5 bg-green-500 text-white rounded-xl font-medium hover:bg-green-600 transition-colors ml-auto">
            Export CSV
        </a>
    </form>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Package Statistics -->
    <div class="bg-white rounded-2xl shadow-luxury overflow-hidden">
        <div class="bg-blue-600 px-6 py-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-white">Package Statistics</h3>
        </div>
        <div class="p-6 grid grid-cols-3 gap-4 text-center">
            <div>
                <p class="text-sm text-luxury-500 mb-1">Total Bookings</p>
                <p class="text-2xl font-bold text-luxury-900">{{ $packageStats['bookings'] ?? 0 }}</p>
            </div>
            <div class="border-l border-r border-luxury-100">
                <p class="text-sm text-luxury-500 mb-1">Total Revenue</p>
                <p class="text-lg font-bold text-blue-600">IDR {{ number_format($packageStats['revenue'] ?? 0, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-sm text-luxury-500 mb-1">Total Profit</p>
                <p class="text-lg font-bold text-green-600">IDR {{ number_format($packageStats['profit'] ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Rent Car Statistics -->
    <div class="bg-white rounded-2xl shadow-luxury overflow-hidden">
        <div class="bg-green-600 px-6 py-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-white">Rent Car Statistics</h3>
        </div>
        <div class="p-6 grid grid-cols-3 gap-4 text-center">
            <div>
                <p class="text-sm text-luxury-500 mb-1">Total Bookings</p>
                <p class="text-2xl font-bold text-luxury-900">{{ $rentcarStats['bookings'] ?? 0 }}</p>
            </div>
            <div class="border-l border-r border-luxury-100">
                <p class="text-sm text-luxury-500 mb-1">Total Revenue</p>
                <p class="text-lg font-bold text-green-600">IDR {{ number_format($rentcarStats['revenue'] ?? 0, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-sm text-luxury-500 mb-1">Total Profit</p>
                <p class="text-lg font-bold text-red-600">IDR {{ number_format($rentcarStats['profit'] ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Report Table -->
<div class="bg-white rounded-2xl shadow-luxury overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-luxury-50 border-b border-luxury-100">
                <tr>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-luxury-500 uppercase tracking-wider">Date</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-luxury-500 uppercase tracking-wider">Customer</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-luxury-500 uppercase tracking-wider">Type</th>
                    <th class="text-right px-6 py-4 text-xs font-semibold text-luxury-500 uppercase tracking-wider">Total Revenue</th>
                    <th class="text-right px-6 py-4 text-xs font-semibold text-luxury-500 uppercase tracking-wider">Profit</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-luxury-500 uppercase tracking-wider">Invoice</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-luxury-100">
                @foreach($bookings as $booking)
                @php
                    $phone = $booking->customer_phone;
                    if (substr($phone, 0, 1) == '0') {
                        $phone = '62' . substr($phone, 1);
                    }
                    $phone = preg_replace('/[^0-9]/', '', $phone);
                    $text = "Halo {$booking->customer_name},%0ABerikut adalah invoice untuk booking Anda:%0A%0AKode Booking: {$booking->booking_code}%0ATotal: IDR " . number_format($booking->total, 0, ',', '.') . "%0A%0ATerima kasih telah memilih LuxeVoyage.";
                @endphp
                <tr class="hover:bg-luxury-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-luxury-700">
                        {{ $booking->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-luxury-900">{{ $booking->customer_name }}</div>
                        <div class="text-xs text-luxury-500">{{ $booking->customer_email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $booking->type === 'package' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                            {{ ucfirst($booking->type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-luxury-900 text-right font-medium">
                        IDR {{ number_format($booking->total, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 text-right font-medium">
                        IDR {{ number_format($booking->profit ?? 0, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.bookings.invoice', $booking->id) }}" target="_blank" class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-xs font-medium hover:bg-red-100 transition-colors inline-flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                PDF
                            </a>
                            <a href="https://wa.me/{{ $phone }}?text={{ $text }}" target="_blank" class="px-3 py-1.5 bg-green-50 text-green-600 rounded-lg text-xs font-medium hover:bg-green-100 transition-colors inline-flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                WA
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($bookings->isEmpty())
    <div class="text-center py-12">
        <svg class="w-16 h-16 text-luxury-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <h3 class="text-lg font-medium text-luxury-700">No Data Available</h3>
        <p class="text-luxury-500">No bookings found for the selected period.</p>
    </div>
    @endif

    @if($bookings->hasPages())
    <div class="px-6 py-4 border-t border-luxury-100">
        {{ $bookings->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
