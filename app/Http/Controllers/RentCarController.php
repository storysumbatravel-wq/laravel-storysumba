<?php

namespace App\Http\Controllers;

use App\Models\RentCar;
use Illuminate\Http\Request;

class RentCarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Ambil daftar unik Brand untuk dropdown filter
        $brands = RentCar::where('status', 'available')
            ->distinct()
            ->orderBy('brand')
            ->pluck('brand');

        // 2. Query utama dengan filter
        $query = RentCar::where('status', 'available');

        // Filter Brand
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        // Filter Transmission
        if ($request->filled('transmission')) {
            $query->where('transmission', $request->transmission);
        }

        // Filter Harga (Opsional, jika ada input min/max di view)
        if ($request->filled('min_price')) {
            $query->where('price_per_day', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price_per_day', '<=', $request->max_price);
        }

        // 3. Ambil data mobil dengan pagination
        $cars = $query->latest()->paginate(9);

        // Kirim variabel $brands DAN $cars ke view
        return view('pages.rentcar.index', compact('cars', 'brands'));
    }

    /**
     * Display the specified resource.
     * INI ADALAH FUNGSI YANG MEMPERBAIKI ERROR ANDA.
     */
    public function show($id)
    {
        // Ambil data mobil berdasarkan ID
        $rentCar = RentCar::where('status', 'available')->findOrFail($id);

        // Kirim variabel $rentCar ke view, BUKAN $booking
        return view('pages.rentcar.show', compact('rentCar'));
    }
}
