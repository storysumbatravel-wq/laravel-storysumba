<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code', 'type',
        'package_id', 'rent_car_id',
        'customer_name', 'customer_email', 'customer_phone',
        'customer_address', 'start_date', 'end_date',
        'pax', 'additional_info',
        'subtotal', 'discount', 'tax', 'total',
        'paid_amount', 'payment_status', 'status', 'notes',

        // -- PENYESUAIAN --
        'with_driver', // Ditambahkan dari kode target
        'cost',        // Ditambahkan untuk menyimpan harga modal (dari controller sebelumnya)
        'profit',      // Ditambahkan untuk menyimpan keuntungan (dari controller sebelumnya)
    ];

    protected $casts = [
        'additional_info' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'with_driver' => 'boolean', // Ditambahkan casting boolean
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($booking) {
            // Generate kode booking otomatis jika kosong
            if (empty($booking->booking_code)) {
                $booking->booking_code = 'LV-' . strtoupper(Str::random(8));
            }
        });
    }

    public function package()
    {
         return $this->belongsTo(\App\Models\Package::class, 'package_id');
    }

    public function rentCar()
    {
        return $this->belongsTo(\App\Models\RentCar::class, 'rent_car_id');
    }

    // Catatan: Fungsi getProfitAttribute dihapus karena kita sekarang menyimpan
    // nilai profit secara langsung di kolom 'profit' di database.
}
