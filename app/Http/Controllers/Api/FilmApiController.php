<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Genre;
use Illuminate\Http\Request;

class FilmApiController extends Controller
{
    /**
     * Film unggulan (rating tertinggi) untuk Hero Section.
     */
    public function featured()
    {
        $film = Film::with(['genres', 'regency.province'])
            ->orderByDesc('rating')
            ->first();

        if (! $film) {
            return response()->json(null, 204);
        }

        return response()->json($this->formatFilm($film));
    }

    /**
     * Film terbaru (urut created_at desc).
     */
    public function latest(Request $request)
    {
        $limit = $request->get('limit', 12);

        $films = Film::with(['genres', 'regency.province'])
            ->latest()
            ->limit($limit)
            ->get()
            ->map(fn ($f) => $this->formatFilm($f));

        return response()->json($films);
    }

    /**
     * Film rating tinggi (urut rating desc).
     */
    public function topRated(Request $request)
    {
        $limit = $request->get('limit', 12);

        $films = Film::with(['genres', 'regency.province'])
            ->orderByDesc('rating')
            ->limit($limit)
            ->get()
            ->map(fn ($f) => $this->formatFilm($f));

        return response()->json($films);
    }

    /**
     * Search & Filter: ?search=...&genre_id=...&sort=latest|rating&page=1
     */
    public function explore(Request $request)
    {
        $search    = $request->get('search');
        $genreId   = $request->get('genre_id');
        $province  = $request->get('province'); // Filter by province name
        $sort      = $request->get('sort', 'latest'); // latest | rating
        $perPage   = (int) $request->get('per_page', 20);

        $query = Film::with(['genres', 'regency.province']);

        // Full-text search by title
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        // Filter by genre
        if ($genreId) {
            $query->whereHas('genres', fn ($q) => $q->where('genres.id', $genreId));
        }

        // Filter by province name
        if ($province) {
            $query->whereHas('regency.province', fn ($q) => $q->where('name', 'like', '%' . $province . '%'));
        }

        // Sorting
        match ($sort) {
            'rating' => $query->orderByDesc('rating'),
            'year'   => $query->orderByDesc('year'),
            default  => $query->latest(),
        };

        $films = $query->paginate($perPage);

        return response()->json([
            'data'         => $films->map(fn ($f) => $this->formatFilm($f))->values(),
            'current_page' => $films->currentPage(),
            'last_page'    => $films->lastPage(),
            'total'        => $films->total(),
        ]);
    }

    /**
     * Daftar semua genre (untuk dropdown filter).
     */
    public function genres()
    {
        $genres = Genre::orderBy('name')->get(['id', 'name']);
        return response()->json($genres);
    }

    /**
     * Detail film.
     */
    public function show($identifier)
    {
        $film = Film::with(['genres', 'regency.province'])
            ->where('id', $identifier)
            ->orWhere('slug', $identifier)
            ->first();

        if (! $film) {
            return response()->json(['message' => 'Film tidak ditemukan'], 404);
        }

        return response()->json($this->formatFilm($film));
    }

    /**
     * Format film ke array yang konsisten.
     */
    private function formatFilm(Film $film): array
    {
        return [
            'id'         => $film->id,
            'title'      => $film->title,
            'slug'       => $film->slug,
            'synopsis'   => $film->synopsis,
            'year'       => $film->year,
            'rating'     => $film->rating,
            'poster_url' => $film->poster
                ? asset('storage/' . $film->poster)
                : null,
            'genres'     => $film->genres->pluck('name'),
            'genre_ids'  => $film->genres->pluck('id'),
            'location'   => optional(optional($film->regency)->province)->name,
            'regency'    => optional($film->regency)->name,
        ];
    }
}
