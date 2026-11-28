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
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\WorkScheduleController;
use App\Http\Controllers\ApotekController;

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
    Route::get('/api/registrasi/available-doctors', [RegistrasiController::class, 'getAvailableDoctors']);
    Route::get('/api/registrasi/booked-slots', [RegistrasiController::class, 'getBookedSlots']);
    Route::resource('antrean', AntreanController::class);
    Route::get('antrean-v2', [AntreanV2Controller::class, 'index'])->name('antrean-v2.index');
    Route::resource('rekam-medis', RekamMedisController::class);
    Route::resource('work-schedules', WorkScheduleController::class);
    Route::get('work-schedules/{workSchedule}/assign', [WorkScheduleController::class, 'assign'])->name('work-schedules.assign');
    Route::post('work-schedules/{workSchedule}/assign', [WorkScheduleController::class, 'storeAssignment'])->name('work-schedules.store-assignment');
    Route::delete('schedule-assignments/{assignment}', [WorkScheduleController::class, 'destroyAssignment'])->name('work-schedules.destroy-assignment');
    
    // API for AJAX
    Route::get('/api/rekam-medis/search-pasien', [RekamMedisController::class, 'searchPasien']);
    Route::get('/api/rekam-medis/pasien/{id}', [RekamMedisController::class, 'getPasienDetail']);
    Route::get('/api/rekam-medis/{id}', [RekamMedisController::class, 'show']);
    Route::get('/api/dokters', [RekamMedisController::class, 'getDokters']);
    Route::get('/api/obats', [RekamMedisController::class, 'getObats']);
    Route::post('/api/rekam-medis', [RekamMedisController::class, 'store']);
    Route::put('/api/rekam-medis/{id}', [RekamMedisController::class, 'update']);
    Route::delete('/api/rekam-medis/{id}', [RekamMedisController::class, 'destroy']);
    Route::get('/api/jadwal-dokter/{dokter_id}', function($dokter_id) {
        return \App\Models\JadwalDokter::where('dokter_id', $dokter_id)
            ->where('status', 'aktif')
            ->get();
    });
});

Route::resource('apotek', ApotekController::class);
