<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentCar extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'brand', 'model', 'year',
        'transmission', 'fuel_type', 'seats',
        'features', 'price_per_day', 'price_per_week',
        'price_per_month', 'image', 'gallery',
        'plate_number', 'status',
        'description_en', 'description_id',
        'with_driver', 'driver_price_per_day', 'is_active',
        'image',
    ];

    protected $casts = [
        'features' => 'array',
        'gallery' => 'array',
        'with_driver' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getDescriptionAttribute()
    {
        return app()->getLocale() === 'id' ? $this->description_id : $this->description_en;
    }

    public function getFormattedPriceAttribute()
    {
        return 'IDR ' . number_format($this->price_per_day, 0, ',', '.') . '/day';
    }
}
