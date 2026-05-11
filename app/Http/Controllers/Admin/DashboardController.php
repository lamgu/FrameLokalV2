<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Province;
use App\Models\Review;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalFilms'      => Film::count(),
            'filmsThisMonth'  => Film::whereMonth('created_at', now()->month)->count(),
            'totalProvinces'  => Province::count(),
            'totalUsers'      => User::count(),
            'usersThisWeek'   => User::where('created_at', '>=', now()->startOfWeek())->count(),
            'totalReviews'    => Review::count(),
            'reviewsToday'    => Review::whereDate('created_at', today())->count(),
            'recentFilms'     => Film::with(['regency.province', 'genres'])->latest()->take(5)->get(),
            'filmsByProvince' => Province::withCount(['regencies as films_count' => function ($q) {
                                    $q->join('films', 'films.regency_id', '=', 'regencies.id');
                                 }])
                                 ->orderByDesc('films_count')
                                 ->take(6)
                                 ->get(),
            'recentReviews'   => Review::with(['user', 'film'])->latest()->take(5)->get(),
        ]);
    }
}
