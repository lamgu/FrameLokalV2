<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $provinces = Province::withCount('regencies')->latest()->paginate(10);
        return view('admin.provinces.index', compact('provinces'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.provinces.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:provinces,name',
        ]);

        Province::create($request->all());

        return redirect()->route('admin.provinces.index')->with('success', 'Provinsi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Province $province)
    {
        $province->load('regencies');
        return view('admin.provinces.show', compact('province'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Province $province)
    {
        return view('admin.provinces.edit', compact('province'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Province $province)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:provinces,name,' . $province->id,
        ]);

        $province->update($request->all());

        return redirect()->route('admin.provinces.index')->with('success', 'Provinsi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Province $province)
    {
        $province->delete();
        return redirect()->route('admin.provinces.index')->with('success', 'Provinsi berhasil dihapus.');
    }
}
