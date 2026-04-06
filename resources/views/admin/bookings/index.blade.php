@extends('layouts.admin')

@section('title', 'Booking Management')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-display font-bold text-luxury-900">All Bookings</h1>
        <p class="text-luxury-500 mt-1">Manage Package and rent car bookings</p>
    </div>

    <a href="{{ route('admin.bookings.create') }}"
       class="px-6 py-3 bg-red-500 text-white rounded-xl font-semibold hover:bg-red-600 transition-colors inline-flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Add Manual Booking
    </a>
</div>

<div class="bg-white rounded-2xl shadow-luxury overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-luxury-50 border-b border-luxury-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-luxury-500 uppercase">Customer</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-luxury-500 uppercase">Type / Item</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-luxury-500 uppercase">Details</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-luxury-500 uppercase">Total</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-luxury-500 uppercase">Status</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-luxury-500 uppercase">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-luxury-100">
            @forelse($bookings as $booking)
                <tr class="hover:bg-luxury-50 transition-colors">

                    {{-- Customer --}}
                    <td class="px-6 py-4">
                        <div class="font-semibold text-luxury-900">
                            {{ $booking->customer_name }}
                        </div>
                        <div class="text-sm text-luxury-500">
                            {{ $booking->customer_email }}
                        </div>
                        <div class="text-xs text-luxury-400">
                            {{ $booking->customer_phone }}
                        </div>
                    </td>

                    {{-- Type & Item --}}
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $booking->type === 'package'
                                ? 'bg-blue-100 text-blue-700'
                                : 'bg-purple-100 text-purple-700' }}">
                            {{ ucfirst($booking->type) }}
                        </span>

                        <div class="text-sm font-medium text-luxury-900 mt-2">
                            @if($booking->type === 'package' && $booking->package)
                                {{ $booking->package->name }}
                            @elseif($booking->type === 'rentcar' && $booking->rentCar)
                                {{ $booking->rentCar->name }}
                            @else
                                <span class="text-luxury-400">N/A</span>
                            @endif
                        </div>
                    </td>

                    {{-- Details --}}
                    <td class="px-6 py-4 text-sm text-luxury-600">
                        @if($booking->type === 'package')
                            <div><strong>Pax:</strong> {{ $booking->pax }}</div>
                            <div><strong>Date:</strong>
                                {{ $booking->start_date?->format('d M Y') ?? '-' }}
                            </div>
                        @else
                            <div><strong>Driver:</strong>
                                {{ $booking->with_driver ? 'Yes' : 'No' }}
                            </div>
                            <div><strong>Pickup:</strong>
                                {{ $booking->start_date?->format('d M Y') ?? '-' }}
                            </div>
                            <div><strong>Return:</strong>
                                {{ $booking->end_date?->format('d M Y') ?? '-' }}
                            </div>
                        @endif
                    </td>

                    {{-- Total (Sudah termasuk biaya tambahan) --}}
                    <td class="px-6 py-4 font-semibold text-luxury-900">
                        IDR {{ number_format($booking->total, 0, ',', '.') }}
                    </td>

                    {{-- Status --}}
                    <td class="px-6 py-4">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'confirmed' => 'bg-green-100 text-green-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                                'completed' => 'bg-blue-100 text-blue-700',
                            ];
                            $colorClass = $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-700';
                        @endphp

                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $colorClass }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>

                    {{-- Actions --}}
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3 flex-wrap">

                            {{-- View --}}
                            <a href="{{ route('admin.bookings.show', $booking->id) }}"
                               class="text-luxury-600 hover:text-luxury-900 font-medium text-sm">
                                View
                            </a>

                            {{-- Quick Confirm --}}
                            @if($booking->status === 'pending')
                                <form action="{{ route('admin.bookings.update-status', $booking->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Mark this booking as Confirmed?');">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit"
                                            class="text-green-600 hover:text-green-800 font-medium text-sm">
                                        Confirm
                                    </button>
                                </form>
                            @endif

                            {{-- Delete --}}
                            <form action="{{ route('admin.bookings.destroy', $booking->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Delete this booking?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-500 hover:text-red-700 font-medium text-sm">
                                    Delete
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-12 text-luxury-500">
                        No bookings found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($bookings->hasPages())
        <div class="px-6 py-4 border-t border-luxury-100">
            {{ $bookings->links() }}
        </div>
    @endif
</div>
@endsection
