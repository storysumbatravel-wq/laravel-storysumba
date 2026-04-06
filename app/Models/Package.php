<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en', 'name_id', 'slug',
        'description_en', 'description_id',
        'destination_en', 'destination_id',
        'duration_days', 'duration_nights', 'max_pax',
        'type', 'image',
        'itinerary_en', 'itinerary_id',
        'includes_en', 'includes_id',
        'excludes_en', 'excludes_id',
        'highlights_en', 'highlights_id',
        'is_featured', 'is_active',
    ];

    protected $casts = [
        'itinerary_en' => 'array',
        'itinerary_id' => 'array',
        'includes_en' => 'array',
        'includes_id' => 'array',
        'excludes_en' => 'array',
        'excludes_id' => 'array',
        'highlights_en' => 'array',
        'highlights_id' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function pricingOptions()
    {
        return $this->hasMany(PackagePricing::class);
    }

    // Accessor untuk nama lokal
    public function getNameAttribute()
    {
        return app()->getLocale() === 'id' ? $this->name_id : $this->name_en;
    }

    public function getDescriptionAttribute()
    {
        return app()->getLocale() === 'id' ? $this->description_id : $this->description_en;
    }

    public function getDestinationAttribute()
    {
        return app()->getLocale() === 'id' ? $this->destination_id : $this->destination_en;
    }

    public function getHighlightsAttribute()
    {
        return app()->getLocale() === 'id' ? $this->highlights_id : $this->highlights_en;
    }

    // Helper untuk mendapatkan harga mulai dari (Starting Price)
    public function getStartingPriceAttribute()
    {
        if ($this->pricingOptions->isNotEmpty()) {
            return $this->pricingOptions->min('price');
        }
        return 0;
    }
}
