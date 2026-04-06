<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\RentCar;
use App\Models\Blog;

class HomeController extends Controller
{
    public function index()
    {
        // PERBAIKAN: Menambahkan ->with('pricingOptions') untuk memuat data harga dinamis
        $featuredPackages = Package::with('pricingOptions')
            ->where('is_featured', true)
            ->where('is_active', true)
            ->latest()
            ->take(3)
            ->get();

        $rentCars = RentCar::where('is_active', true)
            ->latest()
            ->take(3)
            ->get();

        $blogs = Blog::where('is_published', true)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('pages.home', compact('featuredPackages', 'rentCars', 'blogs'));
    }


    public function about()
    {
        return view('pages.about');
    }
}
