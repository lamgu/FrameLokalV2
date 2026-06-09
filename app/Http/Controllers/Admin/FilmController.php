<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Film, Genre, Province, Regency};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FilmController extends Controller
{
    public function index(Request $request)
    {
        $query = Film::with(['regency.province', 'genres']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('synopsis', 'like', "%{$search}%")
                  ->orWhereHas('genres', function($g) use ($search) {
                      $g->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $films  = $query->latest()->get();
        $genres = Genre::all();
        $years  = Film::distinct()->orderByDesc('year')->pluck('year');

        return view('admin.films.index', compact('films', 'genres', 'years'));
    }

    public function create()
    {
        $provinces = Province::orderBy('name')->get();
        $genres    = Genre::orderBy('name')->get();

        return view('admin.films.create', compact('provinces', 'genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'regency_id' => 'required|exists:regencies,id',
            'synopsis'   => 'required',
            'year'       => 'required|integer|min:1950|max:' . (date('Y') + 2),
            'trailer_url'=> 'nullable|url',
            'poster'     => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'genres'     => 'required|array',
            'genres.*'   => 'exists:genres,id',
        ]);

        $posterPath = $request->file('poster')->store('posters', 'public');

        $film = Film::create([
            'title'      => $request->title,
            'slug'       => Str::slug($request->title),
            'regency_id' => $request->regency_id,
            'synopsis'   => $request->synopsis,
            'year'       => $request->year,
            'trailer_url'=> $request->trailer_url,
            'poster'     => $posterPath,
            'rating'     => 0,
        ]);

        $film->genres()->attach($request->genres);

        return redirect()->route('admin.films.index')
                         ->with('success', "Film \"{$film->title}\" berhasil ditambahkan!");
    }

    public function edit(Film $film)
    {
        $provinces = Province::orderBy('name')->get();
        $genres    = Genre::orderBy('name')->get();
        $film->load(['regency.province', 'genres']);

        return view('admin.films.edit', compact('film', 'provinces', 'genres'));
    }

    public function update(Request $request, Film $film)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'regency_id' => 'required|exists:regencies,id',
            'synopsis'   => 'required',
            'year'       => 'required|integer|min:1950|max:' . (date('Y') + 2),
            'trailer_url'=> 'nullable|url',
            'poster'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'genres'     => 'required|array',
            'genres.*'   => 'exists:genres,id',
        ]);

        $data = [
            'title'      => $request->title,
            'slug'       => Str::slug($request->title),
            'regency_id' => $request->regency_id,
            'synopsis'   => $request->synopsis,
            'year'       => $request->year,
            'trailer_url'=> $request->trailer_url,
        ];

        if ($request->hasFile('poster')) {
            // Hapus poster lama
            if ($film->poster) {
                Storage::disk('public')->delete($film->poster);
            }
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $film->update($data);
        $film->genres()->sync($request->genres);

        return redirect()->route('admin.films.index')
                         ->with('success', "Film \"{$film->title}\" berhasil diperbarui!");
    }

    public function destroy(Film $film)
    {
        if ($film->poster) {
            Storage::disk('public')->delete($film->poster);
        }

        $title = $film->title;
        $film->delete();

        return redirect()->route('admin.films.index')
                         ->with('success', "Film \"{$title}\" berhasil dihapus.");
    }

    /**
     * AJAX endpoint: return regencies by province
     */
    public function getRegencies($province_id)
    {
        return response()->json(
            Regency::where('province_id', $province_id)->orderBy('name')->get()
        );
    }
}
