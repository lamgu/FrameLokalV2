<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    // Mass Assignment: kolom yang boleh diisi [cite: 104]
    protected $fillable = ['province_id', 'name'];

    // Relasi balik ke Provinsi (Parent) [cite: 18, 105]
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    // Satu kabupaten bisa memiliki banyak film [cite: 105]
    public function films()
    {
        return $this->hasMany(Film::class);
    }
}