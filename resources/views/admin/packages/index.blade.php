@extends('layouts.admin')

@section('title', 'Manage Packages')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-display font-bold text-luxury-900">Travel Packages</h1>
        <p class="text-luxury-500 text-sm">Manage your tour packages</p>
    </div>
    <a href="{{ route('admin.packages.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-red-500 text-white rounded-xl font-medium hover:bg-red-600 transition-colors shadow-sm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Add Package
    </a>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-2xl shadow-luxury overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-luxury-50 border-b border-luxury-100">
                <tr>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-luxury-500 uppercase tracking-wider">Package</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-luxury-500 uppercase tracking-wider">Destination</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-luxury-500 uppercase tracking-wider">Duration</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-luxury-500 uppercase tracking-wider">Price</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-luxury-500 uppercase tracking-wider">Type</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-luxury-500 uppercase tracking-wider">Status</th>
                    <th class="text-right px-6 py-4 text-xs font-semibold text-luxury-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-luxury-100">
                @forelse($packages as $package)
                <tr class="hover:bg-luxury-50 transition-colors">
                    <td class="px-6 py-4">
                        <div>
                            <p class="font-medium text-luxury-900">{{ $package->name_en }}</p>
                            <p class="text-sm text-luxury-500">{{ $package->name_id }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-luxury-600">{{ $package->destination_en }}</td>
                    <td class="px-6 py-4 text-sm text-luxury-600">{{ $package->duration_days }}D / {{ $package->duration_nights }}N</td>
                    <td class="px-6 py-4">
                        <div>
                            @php $minPrice = $package->pricingOptions->min('price'); @endphp
                            @if($minPrice)
                                <p class="font-semibold text-red-600">IDR {{ number_format($minPrice, 0, ',', '.') }}</p>
                                <p class="text-xs text-luxury-400">Starting Price</p>
                            @else
                                <p class="text-luxury-400">No Price Set</p>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-luxury-100 text-luxury-600 rounded-full text-xs font-medium capitalize">{{ $package->type }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col gap-1">
                            @if($package->is_active)
                            <span class="px-2 py-0.5 bg-green-100 text-green-600 rounded-full text-xs font-medium w-fit">Active</span>
                            @else
                            <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full text-xs font-medium w-fit">Inactive</span>
                            @endif
                            @if($package->is_featured)
                            <span class="px-2 py-0.5 bg-red-100 text-red-600 rounded-full text-xs font-medium w-fit">Featured</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('packages.show', $package->slug) }}" target="_blank" class="p-2 text-luxury-400 hover:text-luxury-600 transition-colors" title="View">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('admin.packages.edit', $package->id) }}" class="p-2 text-luxury-400 hover:text-red-600 transition-colors" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('admin.packages.destroy', $package->id) }}" class="inline" onsubmit="return confirm('Are you sure?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-luxury-400 hover:text-red-500 transition-colors" title="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-luxury-500">
                        No packages found. <a href="{{ route('admin.packages.create') }}" class="text-red-600 hover:underline">Create your first package</a>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($packages->hasPages())
    <div class="px-6 py-4 border-t border-luxury-100">
        {{ $packages->links() }}
    </div>
    @endif
</div>
@endsection
