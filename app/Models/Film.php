<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    // WAJIB mencantumkan semua kolom yang akan diisi secara massal
    protected $fillable = [
        'regency_id', 
        'title', 
        'slug', 
        'poster', 
        'trailer_url',
        'synopsis', 
        'year', 
        'rating'
    ];

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'film_genre');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function recalculateRating()
    {
        $avg = $this->reviews()->whereNotNull('rating')->where('rating', '>', 0)->avg('rating');
        $this->rating = $avg ? round($avg, 1) : 0;
        $this->save();
    }
}