<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Province;

class MapController extends Controller
{
    public function index()
    {
        $provinces = Province::orderBy('name')->get(['id', 'name']);
        return view('user.map', compact('provinces'));
    }
}
