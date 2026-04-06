@extends('layouts.admin')

@section('title', 'Create Package')

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
    <h1 class="text-2xl font-display font-bold text-luxury-900 mb-6">Create New Package</h1>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-xl">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Something went wrong! Please check the following errors:</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.packages.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Kolom Kiri -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Name (English) *</label>
                        <input type="text" name="name_en" value="{{ old('name_en') }}" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-gold-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Name (Indonesian) *</label>
                        <input type="text" name="name_id" value="{{ old('name_id') }}" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-gold-500 focus:border-transparent">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Destination (English) *</label>
                        <input type="text" name="destination_en" value="{{ old('destination_en') }}" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-gold-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Destination (Indonesian) *</label>
                        <input type="text" name="destination_id" value="{{ old('destination_id') }}" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-gold-500 focus:border-transparent">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-luxury-700 mb-2">Description (English) *</label>
                    <textarea name="description_en" rows="4" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-gold-500 focus:border-transparent resize-none">{{ old('description_en') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-luxury-700 mb-2">Description (Indonesian) *</label>
                    <textarea name="description_id" rows="4" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-gold-500 focus:border-transparent resize-none">{{ old('description_id') }}</textarea>
                </div>

                <!-- Package Details -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Days *</label>
                        <input type="number" name="duration_days" value="{{ old('duration_days') }}" required min="1" class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-gold-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Nights *</label>
                        <input type="number" name="duration_nights" value="{{ old('duration_nights') }}" required min="0" class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-gold-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Max Pax</label>
                        <input type="number" name="max_pax" value="{{ old('max_pax', 20) }}" min="1" class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-gold-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Type *</label>
                        <select name="type" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-gold-500 focus:border-transparent">
                            <option value="">Select</option>
                            <option value="domestic" {{ old('type') == 'domestic' ? 'selected' : '' }}>Domestic</option>
                            <option value="international" {{ old('type') == 'international' ? 'selected' : '' }}>International</option>
                            <option value="honeymoon" {{ old('type') == 'honeymoon' ? 'selected' : '' }}>Honeymoon</option>
                            <option value="adventure" {{ old('type') == 'adventure' ? 'selected' : '' }}>Adventure</option>
                            <option value="luxury" {{ old('type') == 'luxury' ? 'selected' : '' }}>Luxury</option>
                            <option value="tour" {{ old('type') == 'tour' ? 'selected' : '' }}>Tour</option>
                        </select>
                    </div>
                </div>

                {{-- PRICING OPTIONS --}}
                <div class="pt-6 border-t border-luxury-100">
                    <h3 class="text-lg font-semibold text-luxury-900 mb-4">Pricing Options (Per Pax)</h3>
                    <p class="text-sm text-luxury-500 mb-4">Define price and cost for each number of participants (Pax).</p>
                    <div id="pricing-container" class="space-y-3"></div>
                    <button type="button" id="btn-add-pricing" class="mt-3 text-sm text-gold-600 hover:text-gold-700 font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Pax Option
                    </button>
                </div>

                {{-- ITINERARY --}}
                <div class="pt-6 border-t border-luxury-100">
                    <h3 class="text-lg font-semibold text-luxury-900 mb-4">Itinerary</h3>
                    <div id="itinerary-container" class="space-y-4"></div>
                    <button type="button" id="btn-add-itinerary" class="mt-3 text-sm text-gold-600 hover:text-gold-700 font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Day
                    </button>
                </div>

                {{-- INCLUDES (PERBAIKAN NAMA INPUT) --}}
                <div class="pt-6 border-t border-luxury-100">
                    <h3 class="text-lg font-semibold text-luxury-900 mb-4">Includes</h3>
                    <div id="includes-container" class="space-y-3"></div>
                    <button type="button" id="btn-add-include" class="mt-3 text-sm text-gold-600 hover:text-gold-700 font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Include
                    </button>
                </div>

                {{-- EXCLUDES (PERBAIKAN NAMA INPUT) --}}
                <div class="pt-6 border-t border-luxury-100">
                    <h3 class="text-lg font-semibold text-luxury-900 mb-4">Excludes</h3>
                    <div id="excludes-container" class="space-y-3"></div>
                    <button type="button" id="btn-add-exclude" class="mt-3 text-sm text-gold-600 hover:text-gold-700 font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Exclude
                    </button>
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Image Upload -->
                <div>
                    <label class="block text-sm font-medium text-luxury-700 mb-2">Featured Image</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-luxury-200 border-dashed rounded-xl hover:border-gold-400 transition-colors">
                        <div class="space-y-2 text-center">
                            <div id="imagePreviewContainer" class="hidden mb-4">
                                <img id="imagePreview" src="#" alt="Preview" class="mx-auto h-32 w-auto rounded-lg object-cover">
                            </div>
                            <svg class="mx-auto h-12 w-12 text-luxury-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-luxury-600 justify-center">
                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-gold-600 hover:text-gold-500">
                                    <span>Upload a file</span>
                                    <input id="file-upload" name="image" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-luxury-500">PNG, JPG, WEBP up to 5MB</p>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="bg-luxury-50 p-4 rounded-xl space-y-3">
                    <h3 class="font-semibold text-luxury-900">Status</h3>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" {{ old('is_active', true) ? 'checked' : '' }} class="w-5 h-5 text-gold-600 border-luxury-300 rounded focus:ring-gold-500">
                        <span class="text-luxury-700">Active</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_featured" {{ old('is_featured') ? 'checked' : '' }} class="w-5 h-5 text-gold-600 border-luxury-300 rounded focus:ring-gold-500">
                        <span class="text-luxury-700">Featured</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="mt-8 pt-6 border-t border-luxury-100 flex items-center gap-4">
            <button type="submit" class="px-6 py-3 bg-gold-500 text-white rounded-xl font-semibold hover:bg-gold-600 transition-colors">
                Create Package
            </button>
            <a href="{{ route('admin.packages.index') }}" class="px-6 py-3 bg-luxury-100 text-luxury-700 rounded-xl font-medium hover:bg-luxury-200 transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
    // IMAGE PREVIEW
    document.getElementById('file-upload').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewContainer = document.getElementById('imagePreviewContainer');
                const previewImg = document.getElementById('imagePreview');
                previewImg.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    // ITINERARY LOGIC
    let itineraryCount = 0;
    function addItinerary(titleEn = '', titleId = '', descEn = '', descId = '') {
        itineraryCount++;
        const container = document.getElementById('itinerary-container');
        const html = `
            <div class="bg-luxury-50 p-4 rounded-xl relative group">
                <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-luxury-400 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-xs font-medium text-luxury-600 mb-1">Title (English)</label>
                        <input type="text" name="itinerary_title_en[]" value="${titleEn}" placeholder="Day ${itineraryCount}: Title" class="w-full px-3 py-2 bg-white border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-luxury-600 mb-1">Title (Indonesian)</label>
                        <input type="text" name="itinerary_title_id[]" value="${titleId}" placeholder="Hari ${itineraryCount}: Judul" class="w-full px-3 py-2 bg-white border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-luxury-600 mb-1">Description (English)</label>
                        <textarea name="itinerary_desc_en[]" rows="2" class="w-full px-3 py-2 bg-white border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500 resize-none">${descEn}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-luxury-600 mb-1">Description (Indonesian)</label>
                        <textarea name="itinerary_desc_id[]" rows="2" class="w-full px-3 py-2 bg-white border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500 resize-none">${descId}</textarea>
                    </div>
                </div>
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
    }
    document.getElementById('btn-add-itinerary').addEventListener('click', addItinerary);

    // INCLUDES LOGIC (PERBAIKAN: name="include_en[]" bukan includes_en[])
    function addInclude(valEn = '', valId = '') {
        const container = document.getElementById('includes-container');
        const html = `
            <div class="flex gap-2 items-start group">
                <div class="flex-1"><input type="text" name="include_en[]" value="${valEn}" placeholder="Include (English)" class="w-full px-3 py-2 bg-luxury-50 border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500"></div>
                <div class="flex-1"><input type="text" name="include_id[]" value="${valId}" placeholder="Include (Indonesian)" class="w-full px-3 py-2 bg-luxury-50 border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500"></div>
                <button type="button" onclick="this.parentElement.remove()" class="p-2 text-luxury-400 hover:text-red-500 mt-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
    }
    document.getElementById('btn-add-include').addEventListener('click', addInclude);

    // EXCLUDES LOGIC (PERBAIKAN: name="exclude_en[]" bukan excludes_en[])
    function addExclude(valEn = '', valId = '') {
        const container = document.getElementById('excludes-container');
        const html = `
            <div class="flex gap-2 items-start group">
                <div class="flex-1"><input type="text" name="exclude_en[]" value="${valEn}" placeholder="Exclude (English)" class="w-full px-3 py-2 bg-luxury-50 border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500"></div>
                <div class="flex-1"><input type="text" name="exclude_id[]" value="${valId}" placeholder="Exclude (Indonesian)" class="w-full px-3 py-2 bg-luxury-50 border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500"></div>
                <button type="button" onclick="this.parentElement.remove()" class="p-2 text-luxury-400 hover:text-red-500 mt-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
    }
    document.getElementById('btn-add-exclude').addEventListener('click', addExclude);

    // PRICING OPTIONS LOGIC
    let pricingCount = 0;
    function addPricingOption(pax = '', price = '', cost = '') {
        const index = pricingCount++;
        const container = document.getElementById('pricing-container');
        const html = `
            <div class="flex gap-2 items-start bg-luxury-50 p-3 rounded-xl group">
                <div class="flex-1">
                    <label class="block text-xs font-medium text-luxury-600 mb-1">Pax</label>
                    <input type="number" name="pricing_options[${index}][pax]" value="${pax}" required min="1" placeholder="e.g. 2" class="w-full px-3 py-2 bg-white border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500">
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-medium text-luxury-600 mb-1">Price (IDR)</label>
                    <input type="number" name="pricing_options[${index}][price]" value="${price}" required min="0" placeholder="Selling Price" class="w-full px-3 py-2 bg-white border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500">
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-medium text-luxury-600 mb-1">Cost (IDR)</label>
                    <input type="number" name="pricing_options[${index}][cost]" value="${cost}" min="0" placeholder="Cost Price" class="w-full px-3 py-2 bg-white border border-luxury-200 rounded-lg text-sm focus:ring-1 focus:ring-gold-500">
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="p-2 text-luxury-400 hover:text-red-500 mt-5 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
    }
    document.getElementById('btn-add-pricing').addEventListener('click', addPricingOption);

    // LOAD OLD INPUT (PERBAIKAN: sesuaikan dengan nama baru)
    document.addEventListener("DOMContentLoaded", function() {
        @if (old('itinerary_title_en'))
            @foreach (old('itinerary_title_en') as $key => $value)
                addItinerary(
                    '{{ old('itinerary_title_en')[$key] ?? '' }}',
                    '{{ old('itinerary_title_id')[$key] ?? '' }}',
                    '{{ old('itinerary_desc_en')[$key] ?? '' }}',
                    '{{ old('itinerary_desc_id')[$key] ?? '' }}'
                );
            @endforeach
        @else
            addItinerary();
        @endif

        {{-- Gunakan nama singular: include_en --}}
        @if (old('include_en'))
            @foreach (old('include_en') as $key => $value)
                addInclude('{{ $value }}', '{{ old('include_id')[$key] ?? '' }}');
            @endforeach
        @else
            addInclude();
        @endif

        {{-- Gunakan nama singular: exclude_en --}}
        @if (old('exclude_en'))
            @foreach (old('exclude_en') as $key => $value)
                addExclude('{{ $value }}', '{{ old('exclude_id')[$key] ?? '' }}');
            @endforeach
        @else
            addExclude();
        @endif

        @if(old('pricing_options'))
            @foreach(old('pricing_options') as $option)
                addPricingOption(
                    "{{ $option['pax'] ?? '' }}",
                    "{{ $option['price'] ?? '' }}",
                    "{{ $option['cost'] ?? '' }}"
                );
            @endforeach
        @else
            addPricingOption();
            addPricingOption();
        @endif
    });
</script>
@endsection
