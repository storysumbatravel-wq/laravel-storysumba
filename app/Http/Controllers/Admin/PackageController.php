<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::latest()->paginate(10);
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_id' => 'required|string|max:255',
            'destination_en' => 'required|string|max:255',
            'destination_id' => 'required|string|max:255',
            'description_en' => 'required',
            'description_id' => 'required',

            'duration_days' => 'required|integer',
            'duration_nights' => 'required|integer',

            'type' => 'required|in:domestic,international,honeymoon,adventure,luxury,tour',
            'max_pax' => 'nullable|integer',

            'image' => 'nullable|image|max:2048',

            // Validasi Itinerary (Array)
            'itinerary_en' => 'nullable|array',
            'itinerary_id' => 'nullable|array',

            // Validasi Include & Exclude (Array)
            'include_en' => 'nullable|array',
            'include_id' => 'nullable|array',
            'exclude_en' => 'nullable|array',
            'exclude_id' => 'nullable|array',

            // Pricing Options
            'pricing_options' => 'required|array',
            'pricing_options.*.pax' => 'required|integer|min:1',
            'pricing_options.*.price' => 'required|numeric|min:0',
            'pricing_options.*.cost' => 'nullable|numeric|min:0',
        ]);

        // Upload Image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('packages', 'public');
            $validated['image'] = $path;
        }

        // Handle Itinerary (Logika manual jika input form berbentuk list terpisah)
        // Jika di form Anda menggunakan name="itinerary_en[][title]" maka bisa langsung $validated.
        // Tapi jika di form pakai name="itinerary_title_en[]" (array terpisah), gunakan logika merge berikut:

        // Cek apakah input datang terpisah (sesuai kode awal Anda) atau sudah gabungan
        if ($request->has('itinerary_title_en')) {
            $itineraryEn = [];
            $itineraryId = [];
            foreach ($request->itinerary_title_en as $index => $titleEn) {
                $itineraryEn[] = [
                    'title' => $titleEn,
                    'description' => $request->itinerary_desc_en[$index] ?? ''
                ];
                $itineraryId[] = [
                    'title' => $request->itinerary_title_id[$index] ?? '',
                    'description' => $request->itinerary_desc_id[$index] ?? ''
                ];
            }
            $validated['itinerary_en'] = $itineraryEn;
            $validated['itinerary_id'] = $itineraryId;
        } else {
            // Jika tidak ada input, set null
            $validated['itinerary_en'] = null;
            $validated['itinerary_id'] = null;
        }

        // Includes & Excludes
        // PERBAIKAN: Menggunakan 'include_en' (singular) sesuai kolom DB
        // Filter untuk menghapus nilai kosong
        $validated['include_en'] = array_filter($request->include_en ?? []);
        $validated['include_id'] = array_filter($request->include_id ?? []);
        $validated['exclude_en'] = array_filter($request->exclude_en ?? []);
        $validated['exclude_id'] = array_filter($request->exclude_id ?? []);

        // Slug & Status
        $validated['slug'] = Str::slug($validated['name_en']);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        // Save Package
        $pricingOptions = $request->pricing_options;
        unset($validated['pricing_options']); // Hapus dari validated array karena disimpan via relasi

        $package = Package::create($validated);

        // Save Pricing Options
        foreach ($pricingOptions as $option) {
            $package->pricingOptions()->create([
                'pax' => $option['pax'],
                'price' => $option['price'],
                'cost' => $option['cost'] ?? 0,
            ]);
        }

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package created successfully.');
    }

    public function show(Package $package)
    {
        $package->load('pricingOptions');
        return view('admin.packages.show', compact('package'));
    }

    public function edit(Package $package)
    {
        $package->load('pricingOptions');
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_id' => 'required|string|max:255',
            'destination_en' => 'required|string|max:255',
            'destination_id' => 'required|string|max:255',
            'description_en' => 'required',
            'description_id' => 'required',
            'duration_days' => 'required|integer',
            'duration_nights' => 'required|integer',
            'type' => 'required|in:domestic,international,honeymoon,adventure,luxury,tour',
            'max_pax' => 'nullable|integer',
            'image' => 'nullable|image|max:2048',

            // Validasi Itinerary
            'itinerary_en' => 'nullable|array',
            'itinerary_id' => 'nullable|array',

            // Validasi Include & Exclude
            'include_en' => 'nullable|array',
            'include_id' => 'nullable|array',
            'exclude_en' => 'nullable|array',
            'exclude_id' => 'nullable|array',

            // Pricing
            'pricing_options' => 'required|array',
            'pricing_options.*.pax' => 'required|integer|min:1',
            'pricing_options.*.price' => 'required|numeric|min:0',
            'pricing_options.*.cost' => 'nullable|numeric|min:0',
        ]);

        // Upload image
        if ($request->hasFile('image')) {
            if ($package->image && Storage::disk('public')->exists($package->image)) {
                Storage::disk('public')->delete($package->image);
            }
            $validated['image'] = $request->file('image')->store('packages', 'public');
        }

        // Itinerary
        if ($request->has('itinerary_title_en')) {
            $itineraryEn = [];
            $itineraryId = [];
            foreach ($request->itinerary_title_en as $i => $titleEn) {
                $itineraryEn[] = ['title' => $titleEn, 'description' => $request->itinerary_desc_en[$i] ?? ''];
                $itineraryId[] = ['title' => $request->itinerary_title_id[$i] ?? '', 'description' => $request->itinerary_desc_id[$i] ?? ''];
            }
            $validated['itinerary_en'] = $itineraryEn;
            $validated['itinerary_id'] = $itineraryId;
        } else {
            $validated['itinerary_en'] = null;
            $validated['itinerary_id'] = null;
        }

        // Includes / Excludes
        // PERBAIKAN: Menggunakan 'include_en' (singular)
        $validated['include_en'] = array_filter($request->include_en ?? []);
        $validated['include_id'] = array_filter($request->include_id ?? []);
        $validated['exclude_en'] = array_filter($request->exclude_en ?? []);
        $validated['exclude_id'] = array_filter($request->exclude_id ?? []);

        // Status & slug
        $validated['slug'] = Str::slug($validated['name_en']);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        // Update package
        $package->update($validated);

        // Update pricing options
        $package->pricingOptions()->delete();
        foreach ($request->pricing_options as $option) {
            $package->pricingOptions()->create([
                'pax' => $option['pax'],
                'price' => $option['price'],
                'cost' => $option['cost'] ?? 0,
            ]);
        }

        return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully.');
    }

    public function destroy(Package $package)
    {
        if ($package->image && Storage::disk('public')->exists($package->image)) {
            Storage::disk('public')->delete($package->image);
        }

        $package->delete();

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package deleted successfully.');
    }
}
