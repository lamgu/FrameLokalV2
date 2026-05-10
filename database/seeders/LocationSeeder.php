<?php
namespace Database\Seeders;

use App\Models\Province;
use App\Models\Regency;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Provinsi
        $jatim = Province::create(['name' => 'Jawa Timur']);
        $jabar = Province::create(['name' => 'Jawa Barat']);
        $dkai  = Province::create(['name' => 'DKI Jakarta']);

        // 2. Data Kabupaten/Kota (Menghubungkan dengan ID Provinsi)
        // Jawa Timur
        Regency::create(['province_id' => $jatim->id, 'name' => 'Malang']);
        Regency::create(['province_id' => $jatim->id, 'name' => 'Surabaya']);
        Regency::create(['province_id' => $jatim->id, 'name' => 'Banyuwangi']);

        // Jawa Barat
        Regency::create(['province_id' => $jabar->id, 'name' => 'Bandung']);
        Regency::create(['province_id' => $jabar->id, 'name' => 'Bogor']);

        // DKI Jakarta
        Regency::create(['province_id' => $dkai->id, 'name' => 'Jakarta Selatan']);
        Regency::create(['province_id' => $dkai->id, 'name' => 'Jakarta Pusat']);
    }
}
