<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\RentCar;
use App\Models\Package;
use App\Models\PackagePricing;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        // 1. VALIDASI
        $rules = [
            'type' => 'required|in:package,rentcar,car',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'start_date' => 'required|date',

            'package_id' => 'required_if:type,package|nullable|exists:packages,id',
            'rent_car_id' => 'required_if:type,rentcar,car|nullable|exists:rent_cars,id',

            // OPTIONAL MANUAL INPUT
            'total' => 'nullable|numeric',
            'cost' => 'nullable|numeric',
            'profit' => 'nullable|numeric',

            // OTHER COSTS (JSON)
            'other_costs' => 'nullable|array',
            'other_costs.*.desc' => 'nullable|string',
            'other_costs.*.price' => 'nullable|numeric',
        ];

        if ($request->type === 'package') {
            $rules['pax'] = 'required|integer|min:1';
            $rules['end_date'] = 'nullable|date|after_or_equal:start_date';
        } else {
            $rules['end_date'] = 'required|date|after_or_equal:start_date';
            $rules['with_driver'] = 'nullable|in:0,1';
        }

        $validated = $request->validate($rules);

        // 2. INISIALISASI
        $typeInput = ($request->type === 'car') ? 'rentcar' : $request->type;
        $bookingCode = 'BOOK-' . strtoupper(Str::random(8));

        $price = 0;
        $subtotal = 0;
        $total = 0;
        $cost = 0;
        $profit = 0;
        $endDate = null;
        $pax = $request->pax ?? 1;

        try {

            /*
            |--------------------------------------------------------------------------
            | AUTO CALCULATION (DEFAULT SYSTEM)
            |--------------------------------------------------------------------------
            */
            if (!$request->filled('total')) {

                if ($typeInput === 'package' && $request->package_id) {

                    $package = Package::find($request->package_id);

                    if ($package) {
                        $pricing = PackagePricing::where('package_id', $package->id)
                            ->where('pax', $request->pax)
                            ->first();

                        if ($pricing) {
                            $price = $pricing->price;
                            $costPerPax = $pricing->cost ?? 0;
                        } else {
                            $price = $package->discount_price ?? $package->price;
                            $costPerPax = $package->cost_price ?? 0;
                        }

                        $subtotal = $price * $request->pax;
                        $cost = $costPerPax * $request->pax;
                        $profit = $subtotal - $cost;
                        $total = $subtotal;

                        $endDate = $request->end_date ?? $request->start_date;
                    }

                } elseif ($typeInput === 'rentcar' && $request->rent_car_id) {

                    $rentCar = RentCar::find($request->rent_car_id);

                    if ($rentCar) {
                        $startDate = Carbon::parse($request->start_date);
                        $endDate = Carbon::parse($request->end_date);
                        $days = $startDate->diffInDays($endDate) + 1;

                        $pricePerDay = $rentCar->price_per_day;
                        $costPerDay = $rentCar->cost_price_per_day ?? 0;

                        $subtotal = $pricePerDay * $days;
                        $cost = $costPerDay * $days;

                        if ($request->boolean('with_driver') && $rentCar->driver_price_per_day) {
                            $subtotal += $rentCar->driver_price_per_day * $days;
                        }

                        $price = $subtotal;
                        $profit = $subtotal - $cost;
                        $total = $subtotal;
                    }
                }

            } else {

                /*
                |--------------------------------------------------------------------------
                | MANUAL INPUT (ADMIN FORM)
                |--------------------------------------------------------------------------
                */
                $subtotal = $request->subtotal ?? $request->total;
$baseTotal = $request->total; // total dari JS (sewa + driver + tambahan)

// Hitung ulang other_costs di backend (ANTI BUG)
$otherCostTotal = 0;

if ($request->has('other_costs')) {
    foreach ($request->other_costs as $costItem) {
        if (isset($costItem['price']) && is_numeric($costItem['price'])) {
            $otherCostTotal += floatval($costItem['price']);
        }
    }
}

// GRAND TOTAL FINAL
$total = $baseTotal;
// (karena di JS sudah include additional charges)

$cost = $request->cost ?? 0;
$profit = $total - $cost;

$price = $total;
            }

            /*
            |--------------------------------------------------------------------------
            | HANDLE OTHER COSTS (JSON)
            |--------------------------------------------------------------------------
            */
            $otherCosts = null;

            if ($typeInput === 'rentcar' && $request->has('other_costs')) {
                $otherCosts = json_encode(array_values($request->other_costs));
            }

            /*
            |--------------------------------------------------------------------------
            | SAVE DATA
            |--------------------------------------------------------------------------
            */
            Booking::create([
                'booking_code' => $bookingCode,
                'type' => $typeInput,
                'package_id' => $validated['package_id'] ?? null,
                'rent_car_id' => $validated['rent_car_id'] ?? null,

                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],

                'start_date' => $validated['start_date'],
                'end_date' => $endDate,

                'pax' => $pax,

                'price' => $price,
                'subtotal' => $subtotal,
                'total' => $total,

                'cost' => $cost,
                'profit' => $profit,

                'with_driver' => ($typeInput === 'rentcar')
                    ? $request->boolean('with_driver')
                    : false,

                'other_costs' => $otherCosts,

                'status' => 'pending',
                'payment_status' => 'unpaid',
            ]);

            return redirect()->back()
                ->with('success', 'Booking berhasil dibuat!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->withInput();
        }
    }
}
