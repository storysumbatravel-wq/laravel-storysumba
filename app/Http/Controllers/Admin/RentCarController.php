<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RentCar;
use Illuminate\Http\Request;

class RentCarController extends Controller
{
    public function index()
    {
        $cars = RentCar::latest()->paginate(10);
        return view('admin.rent-cars.index', compact('cars'));
    }

    public function create()
    {
        return view('admin.rent-cars.create');
    }

    public function store(Request $request)
{
    // 1. Validasi
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'brand' => 'required|string|max:255',
        'model' => 'required|string|max:255',
        'year' => 'required|integer',
        'transmission' => 'required|string',
        'fuel_type' => 'required|string',
        'seats' => 'required|integer',
        'plate_number' => 'required|string|max:50',
        'price_per_day' => 'required|numeric',
        'status' => 'required|string',
        'with_driver' => 'nullable',
        'driver_price_per_day' => 'nullable|numeric',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120', // Max 5MB
    ]);

    // 2. Handle Upload Image (HARUS SEBELUM CREATE)
    if ($request->hasFile('image')) {
        // Simpan file ke storage/app/public/rent-cars
        $validated['image'] = $request->file('image')->store('rent-cars', 'public');
    }

    // 3. Handle Checkbox
    $validated['with_driver'] = $request->has('with_driver');

    // 4. Simpan ke Database
    RentCar::create($validated);

    return redirect()->route('admin.rent-cars.index')
        ->with('success', 'Vehicle added successfully.');
}

    public function show(RentCar $rentCar)
    {
        return view('admin.rent-cars.show', compact('rentCar'));
    }

    public function edit(RentCar $rentCar)
    {
        return view('admin.rent-cars.edit', compact('rentCar'));
    }

    public function update(Request $request, RentCar $rentCar)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'brand' => 'required|string|max:255',
        'model' => 'required|string|max:255',
        'year' => 'required|integer',
        'transmission' => 'required|in:automatic,manual',
        'fuel_type' => 'required|in:petrol,diesel,electric,hybrid',
        'seats' => 'required|integer',
        'price_per_day' => 'required|numeric',
        'plate_number' => 'required|string|max:20',
        'status' => 'required|in:available,rented,maintenance',
        'with_driver' => 'nullable', // Ubah dari boolean agar aman
        'driver_price_per_day' => 'nullable|numeric',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120', // Tambahkan validasi image
    ]);

    // Handle Image Upload saat Update
    if ($request->hasFile('image')) {
        // Hapus gambar lama jika ada
        if ($rentCar->image && \Storage::disk('public')->exists($rentCar->image)) {
            \Storage::disk('public')->delete($rentCar->image);
        }
        // Simpan gambar baru
        $validated['image'] = $request->file('image')->store('rent-cars', 'public');
    }

    $validated['with_driver'] = $request->has('with_driver');

    $rentCar->update($validated);

    return redirect()->route('admin.rent-cars.index')->with('success', 'Car updated successfully.');
}

    public function destroy(RentCar $rentCar)
    {
        $rentCar->delete();
        return redirect()->route('admin.rent-cars.index')->with('success', 'Car deleted successfully.');
    }
}
