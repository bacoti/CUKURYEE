<?php

use App\Http\Controllers\Admin\MitraManagementController;
use App\Http\Controllers\BarbershopController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Mitra\BookingController as MitraBookingController;
use App\Http\Controllers\Mitra\ProfileController as MitraProfileController;
use App\Http\Controllers\Mitra\ScheduleController;
use App\Http\Controllers\Mitra\ServiceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ===== Rute Publik (Bisa diakses siapa saja) =====
Route::get('/', function () {
    // Arahkan ke dashboard jika sudah login, atau ke halaman barbershop jika belum
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('barbershops.index');
})->name('home');

Route::get('/barbershops', [BarbershopController::class, 'index'])->name('barbershops.index');
Route::get('/barbershops/{barbershop}', [BarbershopController::class, 'show'])->name('barbershops.show');

// Endpoint untuk mengambil slot waktu tersedia
Route::get('/availability/{service}', [BookingController::class, 'getAvailability'])->name('availability.show');


// ===== Rute yang Membutuhkan Login =====
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard');

    // Profil User (umum untuk semua role)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Booking (untuk Pelanggan)
    Route::get('/book/service/{service}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('my-bookings.index');
    Route::patch('/my-bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('my-bookings.cancel');
});


// ===== GRUP RUTE KHUSUS MITRA =====
Route::middleware(['auth', 'verified', 'role:mitra'])->prefix('mitra')->name('mitra.')->group(function () {
    // Profil Mitra
    Route::get('/profile/create', [MitraProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [MitraProfileController::class, 'store'])->name('profile.store');

    // Jadwal Mitra
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');
    Route::post('/schedule', [ScheduleController::class, 'store'])->name('schedule.store');

    // Booking Masuk untuk Mitra
    Route::get('/bookings', [MitraBookingController::class, 'index'])->name('bookings.index');
    Route::patch('/bookings/{booking}/status', [MitraBookingController::class, 'updateStatus'])->name('bookings.updateStatus');

    // Layanan Mitra
    Route::resource('services', ServiceController::class);
});


// ===== GRUP RUTE KHUSUS ADMIN =====
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/mitra', [MitraManagementController::class, 'index'])->name('mitra.index');
    Route::patch('/mitra/{mitraProfile}/verify', [MitraManagementController::class, 'verify'])->name('mitra.verify');
    Route::delete('/mitra/{mitraProfile}', [MitraManagementController::class, 'destroy'])->name('mitra.destroy');
});


// Rute Autentikasi dari Laravel Breeze
require __DIR__.'/auth.php';
