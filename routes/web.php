<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TentangKamiController;
use App\Models\TentangKami;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::prefix('auth')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Tentang Kami
    Route::get('tentang-kami', [TentangKamiController::class, 'index'])->name('dashboard.tentang_kami.index');
    Route::get('tentang-kami/tambah', [TentangKamiController::class, 'create'])->name('dashboard.tentang_kami.create');
    Route::post('tentang-kami', [TentangKamiController::class, 'store'])->name('dashboard.tentang_kami.store');
    Route::get('tentang-kami/{slug}/edit', [TentangKamiController::class, 'edit'])->name('dashboard.tentang_kami.edit');
    Route::patch('tentang-kami/{slug}/update', [TentangKamiController::class, 'update'])->name('dashboard.tentang_kami.update');
    Route::delete('tentang-kami/{slug}/delete', [TentangKamiController::class, 'destroy'])->name('dashboard.tentang_kami.delete');
});
