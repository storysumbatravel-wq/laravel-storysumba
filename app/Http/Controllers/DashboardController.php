<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use App\Models\RentCar;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // TAMBAHKAN INI
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ================== DASHBOARD ==================
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $totalRevenue = Booking::where('payment_status','paid')->sum('total');
        $totalProfit  = Booking::where('payment_status','paid')->sum('profit');
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status','pending')->count();

        $recentBookings = Booking::with(['package','rentCar'])
            ->latest()
            ->take(5)
            ->get();

        $monthlyRevenue = Booking::where('payment_status','paid')
            ->whereMonth('created_at', now()->month)
            ->sum('total');

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalProfit',
            'totalBookings',
            'pendingBookings',
            'recentBookings',
            'monthlyRevenue'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | ================== BOOKING LIST ==================
    |--------------------------------------------------------------------------
    */

    public function bookings()
    {
        $bookings = Booking::with(['package','rentCar'])
            ->latest()
            ->paginate(20);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function bookingDetail($id)
    {
        $booking = Booking::with(['package','rentCar'])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    /*
    |--------------------------------------------------------------------------
    | ================== CREATE BOOKING FORM ==================
    |--------------------------------------------------------------------------
    */

    public function createBooking()
    {
        // Ambil package dengan relasi pricingOptions
        $packages = Package::with('pricingOptions')->get();

        // Untuk Rent Car
        $rentCars = RentCar::where('status', 'available')->get();

        return view('admin.bookings.create', compact('packages','rentCars'));
    }

    /*
    |--------------------------------------------------------------------------
    | ================== GET PACKAGE PRICING (AJAX) ==================
    |--------------------------------------------------------------------------
    */

    public function getPackagePricing($id)
    {
        // Eager load relasi pricingOptions
        $package = Package::with('pricingOptions')->find($id);

        if (!$package) {
            return response()->json(['error' => 'Package not found'], 404);
        }

        // Format data pricing options
        $pricingOptions = $package->pricingOptions->map(function($item) {
            return [
                'pax' => $item->pax,
                'price' => $item->price,
                'cost' => $item->cost ?? 0,
            ];
        });

        return response()->json([
            'id' => $package->id,
            'name' => $package->name_en ?? $package->name,
            'pricing_options' => $pricingOptions,
            // Fallback data
            'price' => $package->price ?? 0,
            'cost_price' => $package->cost_price ?? 0,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ================== STORE MANUAL BOOKING ==================
    |--------------------------------------------------------------------------
    */

    public function storeManualBooking(Request $request)
    {
        $rules = [
            'type' => 'required|in:package,rentcar',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
            'start_date' => 'required|date',
            'status' => 'required|in:pending,confirmed,cancelled',
        ];

        if ($request->type === 'package') {
            $rules['package_id'] = 'required|exists:packages,id';
            $rules['pax'] = 'required|integer|min:1';
            $rules['subtotal'] = 'required|numeric';
            $rules['cost'] = 'required|numeric';
        } else {
            $rules['rent_car_id'] = 'required|exists:rent_cars,id';
            $rules['end_date'] = 'required|date|after_or_equal:start_date';
            $rules['with_driver'] = 'nullable|boolean';
        }

        $validated = $request->validate($rules);

        $subtotal = 0;
        $cost = 0;
        $profit = 0;
        $endDate = null;

        if ($request->type === 'package') {
            $subtotal = $request->subtotal;
            $cost = $request->cost;
            $profit = $subtotal - $cost;
        } else {
            $rentCar = RentCar::findOrFail($request->rent_car_id);

            $startDate = Carbon::parse($request->start_date);
            $endDate   = Carbon::parse($request->end_date);

            $days = $startDate->diffInDays($endDate) + 1;

            $subtotal = $rentCar->price_per_day * $days;
            $cost = $rentCar->cost_price_per_day * $days ?? 0;

            if ($request->with_driver && $rentCar->driver_price_per_day) {
                $subtotal += $rentCar->driver_price_per_day * $days;
            }

            $profit = $subtotal - $cost;
        }

        Booking::create([
            'booking_code' => 'BOOK-' . strtoupper(uniqid()),
            'type' => $validated['type'],
            'package_id' => $validated['package_id'] ?? null,
            'rent_car_id' => $validated['rent_car_id'] ?? null,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'start_date' => $validated['start_date'],
            'end_date' => $endDate,
            'pax' => $validated['pax'] ?? 1,
            'with_driver' => $request->with_driver ?? 0,
            'subtotal' => $subtotal,
            'total' => $subtotal,
            'cost' => $cost,
            'profit' => $profit,
            'status' => $validated['status'],
            'payment_status' => 'pending',
            // PERBAIKAN: Gunakan Facade Auth::id()
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.bookings.index')
            ->with('success','Booking created successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | ================== UPDATE STATUS ==================
    |--------------------------------------------------------------------------
    */

    public function updateBookingStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $updateData = [
            'status' => $request->status,
        ];

        if ($request->has('payment_status') && $request->payment_status != null) {
            $updateData['payment_status'] = $request->payment_status;
        }

        $booking->update($updateData);

        return back()->with('success','Booking updated successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | ================== DELETE BOOKING ==================
    |--------------------------------------------------------------------------
    */

    public function destroyBooking($id)
    {
        Booking::findOrFail($id)->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success','Booking deleted successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | ================== REPORTS ==================
    |--------------------------------------------------------------------------
    */

   public function reports(Request $request)
    {
        $query = Booking::query();

        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $bookings = $query->latest()->paginate(15);

        $packageQuery = (clone $query)->where('type', 'package');
        $packageStats = [
            'bookings' => $packageQuery->count(),
            'revenue'  => $packageQuery->sum('total'),
            'profit'   => $packageQuery->sum('profit'),
        ];

        $rentcarQuery = (clone $query)->where('type', 'rentcar');
        $rentcarStats = [
            'bookings' => $rentcarQuery->count(),
            'revenue'  => $rentcarQuery->sum('total'),
            'profit'   => $rentcarQuery->sum('profit'),
        ];

        return view('admin.reports', compact(
            'bookings',
            'packageStats',
            'rentcarStats'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | ================== CONTACT ==================
    |--------------------------------------------------------------------------
    */

    public function contacts()
    {
        $contacts = Contact::latest()->paginate(20);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function replyContact(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $contact->update([
            'reply' => $request->reply,
            'status' => 'replied',
            'replied_at' => now(),
        ]);

        return back()->with('success','Reply sent successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | ================== GENERATE INVOICE ==================
    |--------------------------------------------------------------------------
    */

    public function generateInvoice($id)
    {
        $booking = Booking::findOrFail($id);

        $data = [
            'booking' => $booking,
            'companyName' => 'Aurora Sumba',
            'companyAddress' => 'Jl. Rambu Duka, RT 026/RW 009, Kelurahan Prailiu, Kecamatan Kambera, Kabupaten Sumba Timur, NTT',
            'companyPhone' => '+62 812-4699-4982',
            'date' => now()->format('d M Y'),
        ];

        $pdf = Pdf::loadView('invoice_pdf', $data);

        return $pdf->stream('invoice-'.$booking->booking_code.'.pdf');
    }
}
