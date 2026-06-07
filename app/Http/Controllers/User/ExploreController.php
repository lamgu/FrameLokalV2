<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class ExploreController extends Controller
{
    public function index()
    {
        return view('user.explore');
    }
}
