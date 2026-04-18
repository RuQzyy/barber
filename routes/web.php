<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\KursusController as UserKursusController;
use App\Http\Controllers\Admin\KursusController as AdminKursusController;
use App\Models\Kursus;
use App\Http\Controllers\Admin\GaleriController;
use App\Models\Galeri;
use App\Http\Controllers\Admin\LayananController;
use App\Models\Layanan;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
  use App\Http\Controllers\Admin\ScanController;
  use App\Http\Controllers\Admin\BarberController;
use App\Http\Controllers\Admin\JadwalBarberController;
use App\Http\Controllers\Admin\LaporanController;


// =================== PUBLIC ===================

Route::get('/', function () {
    $kursus = Kursus::oldest()->get();
    $galeri = Galeri::latest()->get();
    $layanans = Layanan::with('items')->get();
    return view('index', compact('kursus', 'galeri', 'layanans'));
})->name('home');


// =================== USER (LOGIN) ===================
Route::middleware(['auth'])->group(function () {

    // ================= DASHBOARD =================
    Route::get('/home', [UserDashboardController::class, 'index'])
        ->name('user.dashboard');

    // ================= BOOKING =================
    Route::get('/booking', [BookingController::class, 'create'])
        ->name('booking.create');

    Route::post('/booking', [BookingController::class, 'store'])
        ->name('booking.store');

        Route::get('/download-qr/{id}', [BookingController::class, 'downloadQr']);

        Route::get('/user/payment/{id}', [BookingController::class, 'payment']);

        Route::post('/user/payment/update/{id}', [BookingController::class, 'updatePaymentStatus']);

      Route::get('/api/antrian', function () {
    return \App\Models\Booking::with(['barber','layananItem'])
        ->whereDate('tanggal', today())
        ->whereIn('status', ['menunggu','diproses'])
        ->orderBy('nomor_antrian')
        ->get();
});

      Route::get('/kursus', [UserKursusController::class,'index'])->name('user.kursus.index');
Route::post('/kursus/daftar/{id}', [UserKursusController::class,'daftar']);
Route::get('/kursus/payment/{id}', [UserKursusController::class,'payment']);
Route::post('/kursus/success/{id}', [UserKursusController::class,'success']);



    // ================= PROFILE =================
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

    // 🔥 SCAN
    Route::get('/scan/{token}', [ScanController::class, 'scan'])->name('scan');

    // 🔥 BOOKING
    Route::get('/booking', [AdminBookingController::class, 'index'])->name('booking');
    Route::post('/booking/{id}/status', [AdminBookingController::class, 'updateStatus']);

    // 🔥 KURSUS
  Route::get('/kursus', [AdminKursusController::class, 'index'])->name('kursus.index');
Route::post('/kursus', [AdminKursusController::class, 'store'])->name('kursus.store');
Route::put('/kursus/{id}', [AdminKursusController::class, 'update'])->name('kursus.update');
Route::delete('/kursus/{id}', [AdminKursusController::class, 'destroy'])->name('kursus.destroy');

    // 🔥 GALERI
    Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');
    Route::post('/galeri', [GaleriController::class, 'store'])->name('galeri.store');
    Route::put('/galeri/{id}', [GaleriController::class, 'update'])->name('galeri.update');
    Route::delete('/galeri/{id}', [GaleriController::class, 'destroy'])->name('galeri.destroy');

    // 🔥 LAYANAN
    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
    Route::post('/layanan', [LayananController::class, 'store'])->name('layanan.store');
    Route::put('/layanan/{id}', [LayananController::class, 'update'])->name('layanan.update');
    Route::delete('/layanan/{id}', [LayananController::class, 'destroy'])->name('layanan.destroy');

     Route::get('/barbers', [BarberController::class, 'index'])->name('barbers.index');
        Route::post('/barbers', [BarberController::class, 'store'])->name('barbers.store');
        Route::put('/barbers/{id}', [BarberController::class, 'update'])->name('barbers.update');
        Route::delete('/barbers/{id}', [BarberController::class, 'destroy'])->name('barbers.destroy');


        Route::get('/jadwal-barber', [JadwalBarberController::class, 'index'])->name('jadwal.index');
        Route::post('/jadwal-barber', [JadwalBarberController::class, 'store'])->name('jadwal.store');

        Route::post('/jadwal-barber/libur', [JadwalBarberController::class, 'tambahLibur'])
    ->name('jadwal.libur');

    Route::delete('/jadwal-barber/libur/{id}', [JadwalBarberController::class, 'hapusLibur'])
    ->name('jadwal.libur.delete');

});

Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan');
Route::get('/admin/laporan/export', [LaporanController::class, 'export'])->name('admin.laporan.export');

require __DIR__.'/auth.php';
