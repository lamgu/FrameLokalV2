<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FilmController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\ProvinceController;
use App\Http\Controllers\Admin\RegencyController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ExploreController;
use App\Http\Controllers\User\MapController;
use App\Http\Controllers\Api\FilmApiController;
use App\Http\Controllers\Api\ReviewApiController;
use App\Http\Controllers\User\FilmController as UserFilmController;

/*
|--------------------------------------------------------------------------
| Public User Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/eksplorasi', [ExploreController::class, 'index'])->name('explore');
Route::get('/peta', [MapController::class, 'index'])->name('map');
Route::get('/film/{identifier}', [UserFilmController::class, 'show'])->name('film.show');

/*
|--------------------------------------------------------------------------
| Public API Endpoints
|--------------------------------------------------------------------------
*/

Route::prefix('api')->name('api.')->group(function () {
    Route::get('/films/featured',  [FilmApiController::class, 'featured'])->name('films.featured');
    Route::get('/films/latest',    [FilmApiController::class, 'latest'])->name('films.latest');
    Route::get('/films/top-rated', [FilmApiController::class, 'topRated'])->name('films.topRated');
    Route::get('/films/explore',   [FilmApiController::class, 'explore'])->name('films.explore');
    Route::get('/genres',          [FilmApiController::class, 'genres'])->name('genres');

    // Film Detail
    Route::get('/films/{identifier}', [FilmApiController::class, 'show'])->name('films.show');

    // Rating & Comments (Separated)
    Route::get('/films/{film}/rating-status', [ReviewApiController::class, 'ratingStatus'])->name('films.ratingStatus');
    Route::get('/films/{film}/raters',        [ReviewApiController::class, 'raters'])->name('films.raters');
    Route::post('/films/{film}/ratings',      [ReviewApiController::class, 'storeRating'])->name('films.storeRating')->middleware('auth');
    
    Route::get('/films/{film}/comments',      [ReviewApiController::class, 'comments'])->name('films.comments');
    Route::post('/films/{film}/comments',     [ReviewApiController::class, 'storeComment'])->name('films.storeComment')->middleware('auth');
    Route::delete('/comments/{review}',       [ReviewApiController::class, 'destroyComment'])->name('comments.destroy')->middleware('auth');

    // Replies
    Route::post('/comments/{review}/replies', [ReviewApiController::class, 'storeReply'])->name('replies.store')->middleware('auth');
    Route::delete('/replies/{reply}',         [ReviewApiController::class, 'destroyReply'])->name('replies.destroy')->middleware('auth');

    // User Activity (authenticated)
    Route::middleware('auth')->group(function () {
        Route::get('/user/ratings',  [ReviewApiController::class, 'userRatings'])->name('user.ratings');
        Route::get('/user/comments', [ReviewApiController::class, 'userComments'])->name('user.comments');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {

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
    
    // Lokasi (Regency - nested inside Province)
    Route::resource('provinces.regencies', RegencyController::class)->only(['store', 'update', 'destroy']);

    // Ulasan (Review)
    Route::resource('reviews', ReviewController::class)->only(['index', 'show', 'destroy']);

    // User Management
    Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::patch('users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (gunakan Laravel Breeze / Fortify / manual)
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\ProfileController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php'; // Uncomment jika menggunakan Breeze

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