<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PerawatController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\AntreanController;
use App\Http\Controllers\AntreanV2Controller;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::resource('dokter', DokterController::class);
    Route::resource('perawat', PerawatController::class);
    Route::resource('pasien', PasienController::class);
    Route::resource('jadwal-dokter', JadwalDokterController::class);
    Route::resource('registrasi', RegistrasiController::class);
    Route::resource('antrean', AntreanController::class);
    Route::get('antrean-v2', [AntreanV2Controller::class, 'index'])->name('antrean-v2.index');
    
    // API for AJAX
    Route::get('/api/jadwal-dokter/{dokter_id}', function($dokter_id) {
        return \App\Models\JadwalDokter::where('dokter_id', $dokter_id)
            ->where('status', 'aktif')
            ->get();
    });
});
