<?php

// app/Models/Film.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $fillable = [
        'title', 
        'slug', 
        'regency_id', 
        'poster', 
        'synopsis', 
        'year', 
        'rating'
    ];  
    // Mengambil data kabupaten asal film
    public function regency() {
        return $this->belongsTo(Regency::class);
    }

    // Mengambil banyak genre yang dimiliki film ini
    public function genres() {
        return $this->belongsToMany(Genre::class, 'film_genre');
    }

    // Relasi untuk fitur sosial (Review & Likes)
    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }
}