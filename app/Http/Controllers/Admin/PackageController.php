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
        // 1. Validasi Dasar
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

            // Validasi Array
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

        // 2. Upload Image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('packages', 'public');
            $validated['image'] = $path;
        }

        // 3. Handle Itinerary (Logika Merge dari input terpisah)
        if ($request->has('itinerary_title_en')) {
            $itineraryEn = [];
            $itineraryId = [];
            foreach ($request->itinerary_title_en as $index => $titleEn) {
                // Hanya simpan jika title tidak kosong
                if (!empty($titleEn) || !empty($request->itinerary_title_id[$index])) {
                    $itineraryEn[] = [
                        'title' => $titleEn,
                        'description' => $request->itinerary_desc_en[$index] ?? ''
                    ];
                    $itineraryId[] = [
                        'title' => $request->itinerary_title_id[$index] ?? '',
                        'description' => $request->itinerary_desc_id[$index] ?? ''
                    ];
                }
            }
            $validated['itinerary_en'] = $itineraryEn;
            $validated['itinerary_id'] = $itineraryId;
        } else {
            $validated['itinerary_en'] = null;
            $validated['itinerary_id'] = null;
        }

        // 4. Logika Menyimpan Array (Include, Exclude) - Sesuai permintaan Anda
        // Menggunakan array_filter untuk menghapus nilai kosong dari form
        $validated['include_en'] = array_filter($request->input('include_en', []));
        $validated['include_id'] = array_filter($request->input('include_id', []));
        $validated['exclude_en'] = array_filter($request->input('exclude_en', []));
        $validated['exclude_id'] = array_filter($request->input('exclude_id', []));

        // 5. Slug & Status
        $validated['slug'] = Str::slug($validated['name_en']);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        // 6. Simpan Package (Pisahkan pricing options dulu)
        $pricingOptions = $request->pricing_options;
        unset($validated['pricing_options']);

        $package = Package::create($validated);

        // 7. Simpan Pricing Options
        if ($pricingOptions) {
            foreach ($pricingOptions as $option) {
                $package->pricingOptions()->create([
                    'pax' => $option['pax'],
                    'price' => $option['price'],
                    'cost' => $option['cost'] ?? 0,
                ]);
            }
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
        // 1. Validasi Dasar
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

            // Validasi Array
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

        // 2. Upload Image
        if ($request->hasFile('image')) {
            if ($package->image && Storage::disk('public')->exists($package->image)) {
                Storage::disk('public')->delete($package->image);
            }
            $validated['image'] = $request->file('image')->store('packages', 'public');
        }

        // 3. Handle Itinerary
        if ($request->has('itinerary_title_en')) {
            $itineraryEn = [];
            $itineraryId = [];
            foreach ($request->itinerary_title_en as $i => $titleEn) {
                if (!empty($titleEn) || !empty($request->itinerary_title_id[$i])) {
                    $itineraryEn[] = ['title' => $titleEn, 'description' => $request->itinerary_desc_en[$i] ?? ''];
                    $itineraryId[] = ['title' => $request->itinerary_title_id[$i] ?? '', 'description' => $request->itinerary_desc_id[$i] ?? ''];
                }
            }
            $validated['itinerary_en'] = $itineraryEn;
            $validated['itinerary_id'] = $itineraryId;
        } else {
            $validated['itinerary_en'] = null;
            $validated['itinerary_id'] = null;
        }

        // 4. Logika Update Array (Include, Exclude) - Sesuai permintaan Anda
        $validated['include_en'] = array_filter($request->input('include_en', []));
        $validated['include_id'] = array_filter($request->input('include_id', []));
        $validated['exclude_en'] = array_filter($request->input('exclude_en', []));
        $validated['exclude_id'] = array_filter($request->input('exclude_id', []));

        // 5. Slug & Status
        $validated['slug'] = Str::slug($validated['name_en']);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        // 6. Update Package
        $package->update($validated);

        // 7. Update Pricing Options
        $package->pricingOptions()->delete(); // Hapus lama, simpan baru
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
