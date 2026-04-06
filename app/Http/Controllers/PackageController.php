<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // TAMBAHKAN INI

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $query = Package::where('is_active', true);

        // Filter by type
        if ($request->type) {
            $query->where('type', $request->type);
        }

        // Filter by destination
        if ($request->destination) {
            $query->where('destination_en', 'like', "%{$request->destination}%")
                  ->orWhere('destination_id', 'like', "%{$request->destination}%");
        }

        // Filter by price range
        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        $packages = $query->latest()->paginate(12);
        $types = ['domestic', 'international', 'honeymoon', 'adventure', 'luxury'];

        return view('pages.packages.index', compact('packages', 'types'));
    }

    public function show($slug)
    {
        // Gunakan with('pricingOptions') agar relasi termuat
        $package = Package::with('pricingOptions')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedPackages = Package::where('type', $package->type)
            ->where('id', '!=', $package->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('pages.packages.show', compact('package', 'relatedPackages'));
    }

    public function store(Request $request)
    {
        // Validasi dasar
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_id' => 'required|string|max:255',
            // ... validasi field lainnya sesuai kebutuhan
            'pricing_options' => 'nullable|array',
            'pricing_options.*.pax' => 'required|integer|min:1',
            'pricing_options.*.price' => 'required|numeric|min:0',
            'pricing_options.*.cost' => 'nullable|numeric|min:0',
        ]);

        // Simpan data Package utama
        $package = new Package();
        $package->name_en = $request->name_en;
        $package->name_id = $request->name_id;
        // Isi field lainnya sesuai request...
        $package->slug = Str::slug($request->name_en); // Sekarang Str sudah dikenali
        $package->is_active = true;

        // Simpan harga dasar (untuk sorting/fallback)
        $package->price = $request->pricing_options[0]['price'] ?? 0;

        $package->save();

        // Simpan Pricing Options via Relasi
        if ($request->has('pricing_options')) {
            foreach ($request->pricing_options as $option) {
                $package->pricingOptions()->create([
                    'pax' => $option['pax'],
                    'price' => $option['price'],
                    'cost' => $option['cost'] ?? 0,
                ]);
            }
        }

        return redirect()->route('admin.packages.index')->with('success', 'Package created successfully.');
    }

    public function update(Request $request, $id)
    {
        // Validasi dasar
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_id' => 'required|string|max:255',
            // ... validasi field lainnya
            'pricing_options' => 'nullable|array',
            'pricing_options.*.pax' => 'required|integer|min:1',
            'pricing_options.*.price' => 'required|numeric|min:0',
            'pricing_options.*.cost' => 'nullable|numeric|min:0',
        ]);

        // Cari package yang ada
        $package = Package::findOrFail($id);

        $package->name_en = $request->name_en;
        $package->name_id = $request->name_id;
        // Update field lainnya...
        $package->slug = Str::slug($request->name_en); // Sekarang Str sudah dikenali

        // Update harga dasar
        $package->price = $request->pricing_options[0]['price'] ?? 0;

        $package->save();

        // Update Pricing Options: Hapus lama, simpan baru
        $package->pricingOptions()->delete();
        if ($request->has('pricing_options')) {
            foreach ($request->pricing_options as $option) {
                $package->pricingOptions()->create([
                    'pax' => $option['pax'],
                    'price' => $option['price'],
                    'cost' => $option['cost'] ?? 0,
                ]);
            }
        }

        return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully.');
    }
}
