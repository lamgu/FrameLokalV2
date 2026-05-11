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
}