<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title_en', 'title_id', 'slug',
        'excerpt_en', 'excerpt_id',
        'content_en', 'content_id',
        'image', 'category', 'tags',
        'is_published', 'published_at',
        'meta_title', 'meta_description', 'views',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTitleAttribute()
    {
        return app()->getLocale() === 'id' ? $this->title_id : $this->title_en;
    }

    public function getExcerptAttribute()
    {
        return app()->getLocale() === 'id' ? $this->excerpt_id : $this->excerpt_en;
    }

    public function getContentAttribute()
    {
        return app()->getLocale() === 'id' ? $this->content_id : $this->content_en;
    }

    public function getImageUrlAttribute()
{
    return $this->image
        ? asset('storage/' . $this->image)
        : 'https://images.unsplash.com/photo-1488085061387-422e29b40080?w=800';
}
}
