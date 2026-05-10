<?php

use App\Http\Controllers\Admin\FilmController;
use App\Http\Controllers\Admin\GenreController;
use Illuminate\Support\Facades\Route;

// --- 1. Rute Publik (Front-end) ---
Route::get('/', function () {
    return view('welcome'); // Halaman landing atau daftar film untuk pengunjung
});

// --- 2. Grup Rute Admin (Back-end) ---
Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard Utama Admin
    Route::get('/dashboard', [App\Http\Controllers\Admin\FilmController::class, 'index'])->name('dashboard');

    // --- CRUD FILM ---
    Route::resource('films', FilmController::class);

    // --- CRUD GENRE ---
    Route::resource('genres', GenreController::class);

    // --- AJAX ROUTE ---
    Route::get('get-regencies/{province_id}', [FilmController::class, 'getRegencies'])->name('getRegencies');

});

