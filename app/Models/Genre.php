<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = ['name'];

    // Relasi Many-to-Many ke Film
    public function films() {
        return $this->belongsToMany(Film::class, 'film_genre');
    }
}
