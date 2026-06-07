<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class FilmController extends Controller
{
    public function show($identifier)
    {
        return view('user.film-detail', compact('identifier'));
    }
}
