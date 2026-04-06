@extends('layouts.admin')

@section('title', 'Edit Vehicle')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.rent-cars.index') }}" class="inline-flex items-center gap-2 text-luxury-600 hover:text-red-600 transition-colors text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Vehicles
    </a>
</div>

<div class="bg-white rounded-2xl shadow-luxury p-8">
    <h1 class="text-2xl font-display font-bold text-luxury-900 mb-6">Edit Vehicle</h1>

    <!-- Ditambahkan enctype="multipart/form-data" untuk upload file -->
    <form method="POST" action="{{ route('admin.rent-cars.update', $rentCar->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Vehicle Info -->
            <div class="space-y-6">
                <h2 class="text-lg font-semibold text-luxury-900 border-b border-luxury-100 pb-2">Vehicle Information</h2>

                <div>
                    <label class="block text-sm font-medium text-luxury-700 mb-2">Vehicle Name *</label>
                    <input type="text" name="name" value="{{ old('name', $rentCar->name) }}" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Brand *</label>
                        <input type="text" name="brand" value="{{ old('brand', $rentCar->brand) }}" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Model *</label>
                        <input type="text" name="model" value="{{ old('model', $rentCar->model) }}" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Year *</label>
                        <input type="number" name="year" value="{{ old('year', $rentCar->year) }}" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Transmission *</label>
                        <select name="transmission" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            <option value="automatic" {{ $rentCar->transmission == 'automatic' ? 'selected' : '' }}>Automatic</option>
                            <option value="manual" {{ $rentCar->transmission == 'manual' ? 'selected' : '' }}>Manual</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Fuel Type *</label>
                        <select name="fuel_type" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            <option value="petrol" {{ $rentCar->fuel_type == 'petrol' ? 'selected' : '' }}>Petrol</option>
                            <option value="diesel" {{ $rentCar->fuel_type == 'diesel' ? 'selected' : '' }}>Diesel</option>
                            <option value="electric" {{ $rentCar->fuel_type == 'electric' ? 'selected' : '' }}>Electric</option>
                            <option value="hybrid" {{ $rentCar->fuel_type == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Seats *</label>
                        <input type="number" name="seats" value="{{ old('seats', $rentCar->seats) }}" required min="1" class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-luxury-700 mb-2">Plate Number *</label>
                    <input type="text" name="plate_number" value="{{ old('plate_number', $rentCar->plate_number) }}" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent uppercase">
                </div>
            </div>

            <!-- Pricing & Status & Image -->
            <div class="space-y-6">
                <h2 class="text-lg font-semibold text-luxury-900 border-b border-luxury-100 pb-2">Pricing & Status</h2>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Price/Day *</label>
                        <input type="number" name="price_per_day" value="{{ old('price_per_day', $rentCar->price_per_day) }}" required min="0" class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Price/Week</label>
                        <input type="number" name="price_per_week" value="{{ old('price_per_week', $rentCar->price_per_week) }}" min="0" class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Price/Month</label>
                        <input type="number" name="price_per_month" value="{{ old('price_per_month', $rentCar->price_per_month) }}" min="0" class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-luxury-700 mb-2">Status *</label>
                    <select name="status" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        <option value="available" {{ $rentCar->status == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="rented" {{ $rentCar->status == 'rented' ? 'selected' : '' }}>Rented</option>
                        <option value="maintenance" {{ $rentCar->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </div>

                <div class="p-4 bg-luxury-50 rounded-xl">
                    <label class="flex items-center gap-3 cursor-pointer mb-3">
                        <input type="checkbox" name="with_driver" {{ $rentCar->with_driver ? 'checked' : '' }} class="w-5 h-5 text-red-600 border-luxury-300 rounded focus:ring-red-500">
                        <span class="text-luxury-700 font-medium">Include Driver Option</span>
                    </label>
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Driver Price/Day</label>
                        <input type="number" name="driver_price_per_day" value="{{ old('driver_price_per_day', $rentCar->driver_price_per_day) }}" min="0" class="w-full px-4 py-3 bg-white border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>
                </div>

                <!-- Section Upload Gambar -->
                <div class="mt-6">
                    <h2 class="text-lg font-semibold text-luxury-900 border-b border-luxury-100 pb-2 mb-4">Vehicle Image</h2>

                    <div class="flex flex-col sm:flex-row gap-6 items-start">
                        <!-- Preview Gambar -->
                        <div class="flex-shrink-0">
                            <div id="imagePreviewContainer" class="w-40 h-28 rounded-xl border-2 border-dashed border-luxury-300 flex items-center justify-center bg-luxury-50 overflow-hidden">
                                @if($rentCar->image)
                                    <img id="imagePreview" src="{{ asset('storage/' . $rentCar->image) }}" alt="Vehicle Image" class="w-full h-full object-cover">
                                @else
                                    <div id="noImagePlaceholder" class="text-center">
                                        <svg class="w-10 h-10 text-luxury-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-xs text-luxury-500 mt-1 block">No Image</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Input File -->
                        <div class="flex-1 w-full">
                            <label class="block text-sm font-medium text-luxury-700 mb-2">Upload New Image</label>
                            <input type="file"
                                   name="image"
                                   id="imageInput"
                                   accept="image/*"
                                   class="w-full text-sm text-luxury-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer">
                            <p class="mt-2 text-xs text-luxury-500">Max file size: 2MB. Supported: JPG, PNG, WEBP.</p>

                            @if($rentCar->image)
                            <div class="mt-3">
                                <label class="flex items-center gap-2 text-sm text-red-600 hover:text-red-800 cursor-pointer">
                                    <input type="checkbox" name="remove_image" value="1" class="rounded text-red-600 focus:ring-red-500">
                                    Remove current image
                                </label>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- End Section Upload Gambar -->
            </div>
        </div>

        <!-- Submit -->
        <div class="mt-8 flex items-center gap-4">
            <button type="submit" class="px-6 py-3 bg-red-500 text-white rounded-xl font-semibold hover:bg-red-600 transition-colors">
                Update Vehicle
            </button>
            <a href="{{ route('admin.rent-cars.index') }}" class="px-6 py-3 bg-luxury-100 text-luxury-700 rounded-xl font-medium hover:bg-luxury-200 transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        const noImagePlaceholder = document.getElementById('noImagePlaceholder');
        const previewContainer = document.getElementById('imagePreviewContainer');

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Hapus placeholder jika ada
                    if (noImagePlaceholder) {
                        noImagePlaceholder.remove();
                    }

                    // Jika element img belum ada, buat baru
                    if (!imagePreview) {
                        const img = document.createElement('img');
                        img.id = 'imagePreview';
                        img.src = e.target.result;
                        img.className = 'w-full h-full object-cover';
                        previewContainer.appendChild(img);
                    } else {
                        // Jika sudah ada, update src
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                    }
                }

                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush
@endsection
