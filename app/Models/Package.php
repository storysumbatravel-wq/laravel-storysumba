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
        // PERBAIKAN: Ubah jadi Singular (include_en) bukan Plural (includes_en)
        'include_en', 'include_id',
        'exclude_en', 'exclude_id',
        'highlights_en', 'highlights_id',
        'is_featured', 'is_active',
    ];

    protected $casts = [
        'itinerary_en' => 'array',
        'itinerary_id' => 'array',
        // PERBAIKAN: Ubah jadi Singular
        'include_en' => 'array',
        'include_id' => 'array',
        'exclude_en' => 'array',
        'exclude_id' => 'array',
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

    // Accessor
    public function getNameAttribute()
    {
        return app()->getLocale() === 'id' ? $this->name_id : $this->name_en;
    }

    public function getStartingPriceAttribute()
    {
        if ($this->pricingOptions->isNotEmpty()) {
            return $this->pricingOptions->min('price');
        }
        return 0;
    }
}
