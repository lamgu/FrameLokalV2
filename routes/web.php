<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FilmController;
use App\Http\Controllers\Admin\GenreController;  // Buat jika belum ada
use App\Http\Controllers\Admin\ProvinceController; // Buat jika belum ada

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('admin.dashboard'); // Ganti ke public homepage nanti
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Film CRUD
    Route::resource('films', FilmController::class);

    // AJAX: Regencies by Province
    Route::get('/regencies/{province_id}', [FilmController::class, 'getRegencies'])
         ->name('regencies.by.province');

    // Genre CRUD
    Route::resource('genres', GenreController::class);

    // Lokasi (Province)
    Route::resource('provinces', ProvinceController::class);
});

/*
|--------------------------------------------------------------------------
| Auth Routes (gunakan Laravel Breeze / Fortify / manual)
|--------------------------------------------------------------------------
*/

// require __DIR__.'/auth.php'; // Uncomment jika menggunakan Breeze

/*
|--------------------------------------------------------------------------
| CATATAN ROUTE
|--------------------------------------------------------------------------
|
| Route yang SUDAH ADA dan dipakai di views:
|   - admin.dashboard            → GET  /admin/dashboard
|   - admin.films.index          → GET  /admin/films
|   - admin.films.create         → GET  /admin/films/create
|   - admin.films.store          → POST /admin/films
|   - admin.films.edit           → GET  /admin/films/{film}/edit
|   - admin.films.update         → PUT  /admin/films/{film}
|   - admin.films.destroy        → DEL  /admin/films/{film}
|   - admin.regencies.by.province→ GET  /admin/regencies/{province_id}
|   - admin.genres.index         → GET  /admin/genres
|   - admin.provinces.index      → GET  /admin/provinces
|
*/