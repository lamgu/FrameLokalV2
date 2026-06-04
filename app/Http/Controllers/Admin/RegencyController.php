<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Http\Request;

class RegencyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Province $province)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $province->regencies()->create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.provinces.show', $province)->with('success', 'Kabupaten/Kota berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Province $province, Regency $regency)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $regency->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.provinces.show', $province)->with('success', 'Kabupaten/Kota berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Province $province, Regency $regency)
    {
        $regency->delete();
        return redirect()->route('admin.provinces.show', $province)->with('success', 'Kabupaten/Kota berhasil dihapus.');
    }
}
