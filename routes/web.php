<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EncuestaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/colors', [ColorController::class, 'index']);
Route::get('/colors/create', [ColorController::class, 'create']);
Route::post('/colors', [ColorController::class, 'store']);
Route::get('/colors/{color}', [ColorController::class, 'show']);
Route::get('/colors/{color}/edit', [ColorController::class, 'edit']);
Route::put('/colors/{color}', [ColorController::class, 'update']);
Route::delete('/colors/{color}', [ColorController::class, 'destroy']);

Route::resource('encuestas', EncuestaController::class);
Route::get('/encuestas', [EncuestaController::class, 'index']);
Route::get('/encuestas/create', [EncuestaController::class, 'create'])->name('encuestas.create');
Route::post('/encuestas', [EncuestaController::class, 'store'])->name('encuestas.store');


Route::get('/encuestas/total', [EncuestaController::class, 'getTotalResponses']);
Route::get('/encuestas/by-day', [EncuestaController::class, 'getResponsesByDay']);
Route::get('/encuestas/age-frequencies', [EncuestaController::class, 'getAgeFrequencies']);
Route::get('/encuestas/color-frequencies', [EncuestaController::class, 'getColorFrequencies']);
Route::get('/encuestas/color-frequencies-by-age', [EncuestaController::class, 'getColorFrequenciesByAge']);
require __DIR__.'/auth.php';

