<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Province;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        return view('user.home');
    }

    public function about()
    {
        $totalFilms = Film::count();
        $totalProvinces = Province::count();
        $totalReviews = Review::count();

        return view('user.about', compact('totalFilms', 'totalProvinces', 'totalReviews'));
    }
}
