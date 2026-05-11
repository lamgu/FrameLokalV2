<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = ['name'];

    // Satu Provinsi memiliki banyak Kabupaten [cite: 18, 116]
    public function regencies()
    {
        return $this->hasMany(Regency::class);
    }
}