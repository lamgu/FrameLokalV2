<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilmController extends Controller
{
    /**
     * Menampilkan daftar film.
     */
    public function index()
    {
        $films = Film::with(['regency', 'genres'])->latest()->get();
        return view('admin.films.index', compact('films'));
    }

    /**
     * Menampilkan form tambah film.
     */
    public function create()
    {
        $provinces = Province::all();
        $genres = Genre::all();
        return view('admin.films.create', compact('provinces', 'genres'));
    }

    /**
     * Menyimpan data film baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => Str::slug($request->title),
            'regency_id' => 'required|exists:regencies,id',
            'synopsis' => 'required',
            'year' => 'required|integer',
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'genres' => 'required|array',
        ]);

        // Handle Upload Poster
        $posterPath = $request->file('poster')->store('posters', 'public');

       $film = Film::create([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title),  
            'regency_id'  => $request->regency_id,
            'synopsis'    => $request->synopsis,
            'year'        => $request->year,
            'poster'      => $posterPath,
            'rating'      => 0,
        ]);
        // Simpan relasi genre (Many to Many)
        $film->genres()->attach($request->genres);

        return redirect()->route('admin.films.index')->with('success', 'Film berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit film.
     */
    public function edit(Film $film)
    {
        $provinces = Province::all();
        $regencies = Regency::where('province_id', $film->regency->province_id)->get();
        $genres = Genre::all();
        $selectedGenres = $film->genres->pluck('id')->toArray();

        return view('admin.films.edit', compact('film', 'provinces', 'regencies', 'genres', 'selectedGenres'));
    }

    /**
     * Memperbarui data film.
     */
    public function update(Request $request, Film $film)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug'        => Str::slug($request->title), 
            'regency_id' => 'required|exists:regencies,id',
            'synopsis' => 'required',
            'year' => 'required|integer',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'genres' => 'required|array',
        ]);

        $data = [
            'title' => $request->title,
            'regency_id' => $request->regency_id,
            'synopsis' => $request->synopsis,
            'year' => $request->year,
            'rating' => $request->rating,
        ];

        // Cek jika ada upload poster baru
        if ($request->hasFile('poster')) {
            // Hapus poster lama
            Storage::disk('public')->delete($film->poster);
            // Simpan poster baru
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $film->update($data);

        // Update relasi genre (Sync akan menghapus yang lama dan mengganti dengan yang baru)
        $film->genres()->sync($request->genres);

        return redirect()->route('admin.films.index')->with('success', 'Film berhasil diperbarui!');
    }

    /**
     * Menghapus film.
     */
    public function destroy(Film $film)
    {
        // Hapus file poster
        Storage::disk('public')->delete($film->poster);
        
        // Hapus relasi di tabel pivot otomatis jika menggunakan onDelete('cascade') di migrasi,
        // jika tidak, gunakan: $film->genres()->detach();
        
        $film->delete();

        return redirect()->route('admin.films.index')->with('success', 'Film berhasil dihapus!');
    }

    /**
     * Fitur AJAX: Mengambil Kabupaten berdasarkan ID Provinsi.
     */
    public function getRegencies($province_id)
    {
        $regencies = Regency::where('province_id', $province_id)->get();
        return response()->json($regencies);
    }
}