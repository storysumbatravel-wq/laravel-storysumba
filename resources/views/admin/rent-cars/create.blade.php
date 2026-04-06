@extends('layouts.admin')

@section('title', 'Add Vehicle')

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
    <h1 class="text-2xl font-display font-bold text-luxury-900 mb-6">Add New Vehicle</h1>

    <!-- TAMPILKAN ERROR VALIDASI DI SINI -->
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-xl">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Something went wrong!</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- TAMBAHKAN enctype="multipart/form-data" -->
    <form method="POST" action="{{ route('admin.rent-cars.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- IMAGE UPLOAD SECTION (BARU) -->
        <div class="mb-8">
            <label class="block text-sm font-medium text-luxury-700 mb-3">
                Vehicle Image
            </label>
            <div id="dropArea"
                class="relative flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-luxury-300 rounded-2xl cursor-pointer bg-luxury-50 hover:bg-luxury-100 transition">

                <input type="file" name="image" id="imageInput" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">

                <div id="uploadPlaceholder" class="text-center">
                    <svg class="mx-auto w-10 h-10 text-luxury-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M7 16V4m0 0L3 8m4-4l4 4M17 20v-8m0 0l-4 4m4-4l4 4"/>
                    </svg>
                    <p class="text-sm text-luxury-600">
                        Drag & drop image here or <span class="text-red-500 font-semibold">browse</span>
                    </p>
                    <p class="text-xs text-luxury-400 mt-1">JPG, PNG, WEBP (max 5MB)</p>
                </div>

                <img id="imagePreview" class="absolute inset-0 w-full h-full object-cover rounded-2xl hidden">
            </div>
        </div>
        <!-- AKHIR IMAGE UPLOAD -->

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Vehicle Info -->
            <div class="space-y-6">
                <h2 class="text-lg font-semibold text-luxury-900 border-b border-luxury-100 pb-2">Vehicle Information</h2>

                <div>
                    <label class="block text-sm font-medium text-luxury-700 mb-2">Vehicle Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="e.g. Toyota Alphard">
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Brand *</label>
                        <input type="text" name="brand" value="{{ old('brand') }}" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Model *</label>
                        <input type="text" name="model" value="{{ old('model') }}" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Year *</label>
                        <input type="number" name="year" value="{{ old('year', date('Y')) }}" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Transmission *</label>
                        <select name="transmission" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            <option value="automatic" {{ old('transmission') == 'automatic' ? 'selected' : '' }}>Automatic</option>
                            <option value="manual" {{ old('transmission') == 'manual' ? 'selected' : '' }}>Manual</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Fuel Type *</label>
                        <select name="fuel_type" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            <option value="petrol" {{ old('fuel_type') == 'petrol' ? 'selected' : '' }}>Petrol</option>
                            <option value="diesel" {{ old('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                            <option value="electric" {{ old('fuel_type') == 'electric' ? 'selected' : '' }}>Electric</option>
                            <option value="hybrid" {{ old('fuel_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Seats *</label>
                        <input type="number" name="seats" value="{{ old('seats') }}" required min="1" class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-luxury-700 mb-2">Plate Number *</label>
                    <input type="text" name="plate_number" value="{{ old('plate_number') }}" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent uppercase" placeholder="B 1234 LUX">
                </div>
            </div>

            <!-- Pricing & Status -->
            <div class="space-y-6">
                <h2 class="text-lg font-semibold text-luxury-900 border-b border-luxury-100 pb-2">Pricing & Status</h2>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Price/Day *</label>
                        <input type="number" name="price_per_day" value="{{ old('price_per_day') }}" required min="0" class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-luxury-700 mb-2">Status *</label>
                    <select name="status" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="rented" {{ old('status') == 'rented' ? 'selected' : '' }}>Rented</option>
                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </div>

                <div class="p-4 bg-luxury-50 rounded-xl">
                    <label class="flex items-center gap-3 cursor-pointer mb-3">
                        <input type="checkbox" name="with_driver" {{ old('with_driver') ? 'checked' : '' }} class="w-5 h-5 text-red-600 border-luxury-300 rounded focus:ring-red-500">
                        <span class="text-luxury-700 font-medium">Include Driver Option</span>
                    </label>
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Driver Price/Day</label>
                        <input type="number" name="driver_price_per_day" value="{{ old('driver_price_per_day') }}" min="0" class="w-full px-4 py-3 bg-white border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="mt-8 flex items-center gap-4">
            <button type="submit" class="px-6 py-3 bg-red-500 text-white rounded-xl font-semibold hover:bg-red-600 transition-colors">
                Add Vehicle
            </button>
            <a href="{{ route('admin.rent-cars.index') }}" class="px-6 py-3 bg-luxury-100 text-luxury-700 rounded-xl font-medium hover:bg-luxury-200 transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>

<!-- Script untuk Preview Image -->
<script>
const dropArea = document.getElementById('dropArea');
const imageInput = document.getElementById('imageInput');
const preview = document.getElementById('imagePreview');
const placeholder = document.getElementById('uploadPlaceholder');

imageInput.addEventListener('change', handleFile);

dropArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropArea.classList.add('border-red-500', 'bg-red-50');
});

dropArea.addEventListener('dragleave', () => {
    dropArea.classList.remove('border-red-500', 'bg-red-50');
});

dropArea.addEventListener('drop', (e) => {
    e.preventDefault();
    dropArea.classList.remove('border-red-500', 'bg-red-50');
    imageInput.files = e.dataTransfer.files;
    handleFile();
});

function handleFile() {
    const file = imageInput.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        preview.src = e.target.result;
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');
    };
    reader.readAsDataURL(file);
}
</script>
@endsection
