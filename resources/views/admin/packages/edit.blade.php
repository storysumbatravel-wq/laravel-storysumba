@extends('layouts.admin')

@section('title', 'Edit Package')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.packages.index') }}" class="inline-flex items-center gap-2 text-luxury-600 hover:text-gold-600 transition-colors text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Packages
    </a>
</div>

<div class="bg-white rounded-2xl shadow-luxury p-8">
    <h1 class="text-2xl font-display font-bold text-luxury-900 mb-6">Edit Package</h1>

    <form method="POST" action="{{ route('admin.packages.update', $package->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Kolom Kiri: Konten & Detail -->
            <div class="lg:col-span-2 space-y-8">

                <!-- Basic Info English -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-luxury-900 border-b border-luxury-100 pb-2">English Content</h2>
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Name (English) *</label>
                        <input type="text" name="name_en" value="{{ old('name_en', $package->name_en) }}" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-gold-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Destination (English) *</label>
                        <input type="text" name="destination_en" value="{{ old('destination_en', $package->destination_en) }}" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-gold-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Description (English) *</label>
                        <textarea name="description_en" rows="4" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-gold-500 focus:border-transparent resize-none">{{ old('description_en', $package->description_en) }}</textarea>
                    </div>
                </div>

                <!-- Basic Info Indonesian -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-luxury-900 border-b border-luxury-100 pb-2">Indonesian Content</h2>
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Name (Indonesian) *</label>
                        <input type="text" name="name_id" value="{{ old('name_id', $package->name_id) }}" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-gold-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Destination (Indonesian) *</label>
                        <input type="text" name="destination_id" value="{{ old('destination_id', $package->destination_id) }}" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-gold-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Description (Indonesian) *</label>
                        <textarea name="description_id" rows="4" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-gold-500 focus:border-transparent resize-none">{{ old('description_id', $package->description_id) }}</textarea>
                    </div>
                </div>

                <!-- Package Details -->
                <div class="pt-4 border-t border-luxury-100 space-y-4">
                    <h2 class="text-lg font-semibold text-luxury-900 pb-2">Package Details</h2>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-luxury-700 mb-2">Days *</label>
                            <input type="number" name="duration_days" value="{{ old('duration_days', $package->duration_days) }}" required min="1" class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-gold-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-luxury-700 mb-2">Nights *</label>
                            <input type="number" name="duration_nights" value="{{ old('duration_nights', $package->duration_nights) }}" required min="0" class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-gold-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-luxury-700 mb-2">Max Pax</label>
                            <input type="number" name="max_pax" value="{{ old('max_pax', $package->max_pax) }}" min="1" class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-gold-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-luxury-700 mb-2">Type *</label>
                            <select name="type" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-gold-500 focus:border-transparent">
                                <option value="domestic" {{ $package->type == 'domestic' ? 'selected' : '' }}>Domestic</option>
                                <option value="international" {{ $package->type == 'international' ? 'selected' : '' }}>International</option>
                                <option value="honeymoon" {{ $package->type == 'honeymoon' ? 'selected' : '' }}>Honeymoon</option>
                                <option value="adventure" {{ $package->type == 'adventure' ? 'selected' : '' }}>Adventure</option>
                                <option value="luxury" {{ $package->type == 'luxury' ? 'selected' : '' }}>Luxury</option>
                                <option value="tour" {{ $package->type == 'tour' ? 'selected' : '' }}>Tour</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-luxury-700 mb-2">Price (IDR) *</label>
                            <input type="number" name="price" value="{{ old('price', $package->price) }}" required min="0" class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-gold-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-luxury-700 mb-2">Discount Price</label>
                            <input type="number" name="discount_price" value="{{ old('discount_price', $package->discount_price) }}" min="0" class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-gold-500 focus:border-transparent">
                        </div>
                    </div>
                </div>

                {{-- ==================== ITINERARY SECTION ==================== --}}
                <div class="pt-6 border-t border-luxury-100">
                    <h3 class="text-lg font-semibold text-luxury-900 mb-4">Itinerary</h3>
                    <div id="itinerary-container" class="space-y-4">
                        @php
                            // Menggunakan variabel singular sesuai database
                            $itinerary_en = $package->itinerary_en ?? [];
                            $itinerary_id = $package->itinerary_id ?? [];
                            $maxCount = max(count($itinerary_en), count($itinerary_id));
                        @endphp

                        @if($maxCount > 0)
                            @for($i = 0; $i < $maxCount; $i++)
                                <div class="bg-luxury-50 p-4 rounded-xl relative itinerary-item">
                                    <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-luxury-400 hover:text-red-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                                        <div>
                                            <label class="block text-xs font-medium text-luxury-600 mb-1">Title (English)</label>
                                            <input type="text" name="itinerary_title_en[]" value="{{ $itinerary_en[$i]['title'] ?? (is_string(($itinerary_en[$i] ?? null)) ? $itinerary_en[$i] : '') }}" class="w-full px-3 py-2 bg-white border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-luxury-600 mb-1">Title (Indonesian)</label>
                                            <input type="text" name="itinerary_title_id[]" value="{{ $itinerary_id[$i]['title'] ?? (is_string(($itinerary_id[$i] ?? null)) ? $itinerary_id[$i] : '') }}" class="w-full px-3 py-2 bg-white border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-xs font-medium text-luxury-600 mb-1">Description (English)</label>
                                            <textarea name="itinerary_desc_en[]" rows="2" class="w-full px-3 py-2 bg-white border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500 resize-none">{{ $itinerary_en[$i]['description'] ?? '' }}</textarea>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-luxury-600 mb-1">Description (Indonesian)</label>
                                            <textarea name="itinerary_desc_id[]" rows="2" class="w-full px-3 py-2 bg-white border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500 resize-none">{{ $itinerary_id[$i]['description'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        @endif
                    </div>
                    <button type="button" onclick="addItinerary()" class="mt-3 text-sm text-gold-600 hover:text-gold-700 font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Day
                    </button>
                </div>

                {{-- ==================== INCLUDES SECTION (PERBAIKAN NAMA) ==================== --}}
                <div class="pt-6 border-t border-luxury-100">
                    <h3 class="text-lg font-semibold text-luxury-900 mb-4">Includes</h3>
                    <div id="includes-container" class="space-y-3">
                        {{-- Menggunakan $package->include_en (singular) --}}
                        @if(!empty($package->include_en))
                            @foreach($package->include_en as $key => $include)
                                <div class="flex gap-2 items-start include-item">
                                    <div class="flex-1">
                                        <input type="text" name="include_en[]" value="{{ $include }}" placeholder="Include (English)" class="w-full px-3 py-2 bg-luxury-50 border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500">
                                    </div>
                                    <div class="flex-1">
                                        <input type="text" name="include_id[]" value="{{ $package->include_id[$key] ?? '' }}" placeholder="Include (Indonesian)" class="w-full px-3 py-2 bg-luxury-50 border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500">
                                    </div>
                                    <button type="button" onclick="this.parentElement.remove()" class="p-2 text-luxury-400 hover:text-red-500 mt-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button type="button" onclick="addInclude()" class="mt-3 text-sm text-gold-600 hover:text-gold-700 font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Include
                    </button>
                </div>

                {{-- ==================== EXCLUDES SECTION (PERBAIKAN NAMA) ==================== --}}
                <div class="pt-6 border-t border-luxury-100">
                    <h3 class="text-lg font-semibold text-luxury-900 mb-4">Excludes</h3>
                    <div id="excludes-container" class="space-y-3">
                         {{-- Menggunakan $package->exclude_en (singular) --}}
                        @if(!empty($package->exclude_en))
                            @foreach($package->exclude_en as $key => $exclude)
                                <div class="flex gap-2 items-start exclude-item">
                                    <div class="flex-1">
                                        <input type="text" name="exclude_en[]" value="{{ $exclude }}" placeholder="Exclude (English)" class="w-full px-3 py-2 bg-luxury-50 border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500">
                                    </div>
                                    <div class="flex-1">
                                        <input type="text" name="exclude_id[]" value="{{ $package->exclude_id[$key] ?? '' }}" placeholder="Exclude (Indonesian)" class="w-full px-3 py-2 bg-luxury-50 border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500">
                                    </div>
                                    <button type="button" onclick="this.parentElement.remove()" class="p-2 text-luxury-400 hover:text-red-500 mt-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button type="button" onclick="addExclude()" class="mt-3 text-sm text-gold-600 hover:text-gold-700 font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Exclude
                    </button>
                </div>

                {{-- ==================== MULTIPLE PRICING OPTION SECTION ==================== --}}
                <div class="pt-6 border-t border-luxury-100">
                    <h3 class="text-lg font-semibold text-luxury-900 mb-4">Pricing Options</h3>
                    <p class="text-sm text-luxury-500 mb-4">Define price and cost for each number of participants (Pax).</p>

                    <div id="pricing-container" class="space-y-3">
                        @foreach($package->pricingOptions as $index => $option)
                        <div class="flex gap-2 items-start bg-luxury-50 p-3 rounded-xl group pricing-item">
                            <div class="flex-1">
                                <label class="block text-xs font-medium text-luxury-600 mb-1">Pax</label>
                                <input type="number" name="pricing_options[{{ $index }}][pax]" value="{{ $option->pax }}" required min="1" class="w-full px-3 py-2 bg-white border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500">
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-medium text-luxury-600 mb-1">Price (IDR)</label>
                                <input type="number" name="pricing_options[{{ $index }}][price]" value="{{ $option->price }}" required min="0" class="w-full px-3 py-2 bg-white border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500">
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-medium text-luxury-600 mb-1">Cost (IDR)</label>
                                <input type="number" name="pricing_options[{{ $index }}][cost]" value="{{ $option->cost }}" min="0" class="w-full px-3 py-2 bg-white border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500">
                            </div>
                            <button type="button" onclick="this.parentElement.remove()" class="p-2 text-luxury-400 hover:text-red-500 mt-5 opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" onclick="addPricing()" class="mt-3 text-sm text-gold-600 hover:text-gold-700 font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Pricing Option
                    </button>
                </div>
            </div>

            <!-- Kolom Kanan: Gambar & Status -->
            <div class="lg:col-span-1 space-y-6">

                <!-- Image Upload -->
                <div>
                    <label class="block text-sm font-medium text-luxury-700 mb-2">Featured Image</label>

                    <div class="mt-1 flex flex-col items-center justify-center px-6 pt-5 pb-6 border-2 border-luxury-200 border-dashed rounded-xl hover:border-gold-400 transition-colors">

                        <!-- Preview Image -->
                        <img
                            id="imagePreview"
                            src="{{ $package->image ? asset('storage/'.$package->image) : asset('images/default-package.jpg') }}"
                            class="h-40 w-auto rounded-lg object-contain mb-3"
                        >

                        <!-- Upload Button -->
                        <input
                            id="file-upload"
                            name="image"
                            type="file"
                            accept="image/*"
                            class="hidden"
                            onchange="previewImage(event)"
                        >

                        <label for="file-upload"
                            class="cursor-pointer text-sm text-gold-600 hover:text-gold-500 font-medium bg-white px-3 py-1 rounded border border-luxury-200 shadow-sm">
                            Change Image
                        </label>

                        <p class="text-xs text-luxury-500 mt-2">Leave empty to keep current image.</p>

                    </div>
                </div>

                <!-- Status -->
                <div class="bg-luxury-50 p-4 rounded-xl space-y-3">
                    <h3 class="font-semibold text-luxury-900">Status</h3>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" {{ $package->is_active ? 'checked' : '' }} class="w-5 h-5 text-gold-600 border-luxury-300 rounded focus:ring-gold-500">
                        <span class="text-luxury-700">Active</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_featured" {{ $package->is_featured ? 'checked' : '' }} class="w-5 h-5 text-gold-600 border-luxury-300 rounded focus:ring-gold-500">
                        <span class="text-luxury-700">Featured</span>
                    </label>
                </div>

            </div>
        </div>

        <!-- Submit -->
        <div class="mt-8 pt-6 border-t border-luxury-100 flex items-center gap-4">
            <button type="submit" class="px-6 py-3 bg-gold-500 text-white rounded-xl font-semibold hover:bg-gold-600 transition-colors shadow-sm">
                Update Package
            </button>
            <a href="{{ route('admin.packages.index') }}" class="px-6 py-3 bg-luxury-100 text-luxury-700 rounded-xl font-medium hover:bg-luxury-200 transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
    // Image Preview
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');
        if(input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // --- ITINERARY LOGIC ---
    function addItinerary() {
        const container = document.getElementById('itinerary-container');
        const count = container.children.length + 1;
        const html = `
            <div class="bg-luxury-50 p-4 rounded-xl relative itinerary-item">
                <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-luxury-400 hover:text-red-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-xs font-medium text-luxury-600 mb-1">Title (English)</label>
                        <input type="text" name="itinerary_title_en[]" placeholder="Day ${count}: Title" class="w-full px-3 py-2 bg-white border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-luxury-600 mb-1">Title (Indonesian)</label>
                        <input type="text" name="itinerary_title_id[]" placeholder="Hari ${count}: Judul" class="w-full px-3 py-2 bg-white border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-luxury-600 mb-1">Description (English)</label>
                        <textarea name="itinerary_desc_en[]" rows="2" class="w-full px-3 py-2 bg-white border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500 resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-luxury-600 mb-1">Description (Indonesian)</label>
                        <textarea name="itinerary_desc_id[]" rows="2" class="w-full px-3 py-2 bg-white border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500 resize-none"></textarea>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    }

    // --- INCLUDES LOGIC (PERBAIKAN: name="include_en[]") ---
    function addInclude() {
        const container = document.getElementById('includes-container');
        const html = `
            <div class="flex gap-2 items-start include-item">
                <div class="flex-1">
                    <input type="text" name="include_en[]" placeholder="Include (English)" class="w-full px-3 py-2 bg-luxury-50 border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500">
                </div>
                <div class="flex-1">
                    <input type="text" name="include_id[]" placeholder="Include (Indonesian)" class="w-full px-3 py-2 bg-luxury-50 border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500">
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="p-2 text-luxury-400 hover:text-red-500 mt-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    }

    // --- EXCLUDES LOGIC (PERBAIKAN: name="exclude_en[]") ---
    function addExclude() {
        const container = document.getElementById('excludes-container');
        const html = `
            <div class="flex gap-2 items-start exclude-item">
                <div class="flex-1">
                    <input type="text" name="exclude_en[]" placeholder="Exclude (English)" class="w-full px-3 py-2 bg-luxury-50 border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500">
                </div>
                <div class="flex-1">
                    <input type="text" name="exclude_id[]" placeholder="Exclude (Indonesian)" class="w-full px-3 py-2 bg-luxury-50 border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500">
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="p-2 text-luxury-400 hover:text-red-500 mt-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    }

   // --- PRICING LOGIC ---
    let pricingIndex = {{ $package->pricingOptions->count() }};

    function addPricing(pax = '', price = '', cost = '') {
        const container = document.getElementById('pricing-container');
        const html = `
            <div class="flex gap-2 items-start bg-luxury-50 p-3 rounded-xl group pricing-item">
                <div class="flex-1">
                    <label class="block text-xs font-medium text-luxury-600 mb-1">Pax</label>
                    <input type="number" name="pricing_options[${pricingIndex}][pax]" value="${pax}" required min="1" class="w-full px-3 py-2 bg-white border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500">
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-medium text-luxury-600 mb-1">Price (IDR)</label>
                    <input type="number" name="pricing_options[${pricingIndex}][price]" value="${price}" required min="0" class="w-full px-3 py-2 bg-white border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500">
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-medium text-luxury-600 mb-1">Cost (IDR)</label>
                    <input type="number" name="pricing_options[${pricingIndex}][cost]" value="${cost}" min="0" class="w-full px-3 py-2 bg-white border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500">
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="p-2 text-luxury-400 hover:text-red-500 mt-5 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        pricingIndex++;
    }
</script>
@endsection
