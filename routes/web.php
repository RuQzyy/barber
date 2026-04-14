<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\KursusController;
use App\Models\Kursus;
use App\Http\Controllers\Admin\GaleriController;
use App\Models\Galeri;
use App\Http\Controllers\Admin\LayananController;
use App\Models\Layanan;
use App\Http\Controllers\User\UserDashboardController;

// =================== PUBLIC ===================

Route::get('/', function () {
    $kursus = Kursus::oldest()->get();
    $galeri = Galeri::latest()->get();
    $layanans = Layanan::with('items')->get();
    return view('index', compact('kursus', 'galeri', 'layanans'));
})->name('home');


// =================== USER (LOGIN) ===================
Route::middleware(['auth'])->group(function () {

    Route::get('/home', [UserDashboardController::class, 'index'])
        ->name('user.dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

// =================== ADMIN ===================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/kursus', [KursusController::class, 'index'])->name('kursus.index');
    Route::post('/kursus', [KursusController::class, 'store'])->name('kursus.store');
    Route::put('/kursus/{id}', [KursusController::class, 'update'])->name('kursus.update');
    Route::delete('/kursus/{id}', [KursusController::class, 'destroy'])->name('kursus.destroy');

});


Route::prefix('admin')->name('admin.')->middleware(['auth','role:admin'])->group(function () {

    Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');
    Route::post('/galeri', [GaleriController::class, 'store'])->name('galeri.store');
    Route::put('/galeri/{id}', [GaleriController::class, 'update'])->name('galeri.update');
    Route::delete('/galeri/{id}', [GaleriController::class, 'destroy'])->name('galeri.destroy');

});


Route::prefix('admin')->name('admin.')->middleware(['auth','role:admin'])->group(function () {

    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
    Route::post('/layanan', [LayananController::class, 'store'])->name('layanan.store');
    Route::put('/layanan/{id}', [LayananController::class, 'update'])->name('layanan.update');
    Route::delete('/layanan/{id}', [LayananController::class, 'destroy'])->name('layanan.destroy');

});

require __DIR__.'/auth.php';
