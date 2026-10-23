<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\Admin\ObatController;
use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\PeriksaPasienController;
use App\Http\Controllers\RiwayatPasienController;
use App\Http\Controllers\Admin\AdminPoliController;
use Illuminate\Support\Facades\Route;

// UMUM

Route::get('/', function () {
    return view('welcome');
});

// AUTH

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister']);

Route::post('/register', [AuthController::class, 'register'])
    ->name('register');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// ADMIN

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('polis', AdminPoliController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('pasien', PasienController::class);
    Route::resource('obat', ObatController::class);
});


// DOKTER

Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->group(function () {
    Route::get('/dashboard', function () {
        return view('dokter.dashboard');
    })->name('dokter.dashboard');

    Route::resource('jadwal-periksa', JadwalPeriksaController::class);



        // Periksa Pasien
        Route::get(
            '/periksa-pasien',
            [PeriksaPasienController::class, 'index']
        )->name('periksa-pasien.index');

        Route::get(
            '/periksa-pasien/create',
            [PeriksaPasienController::class, 'create']
        )->name('periksa-pasien.create');

        Route::post(
            '/periksa-pasien',
            [PeriksaPasienController::class, 'store']
        )->name('periksa-pasien.store');


        // Riwayat Pasien
        Route::get(
            '/riwayat-pasien',
            [RiwayatPasienController::class, 'index']
        )->name('riwayat-pasien.index');

    });

// PASIEN

Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function () {

    Route::get('/dashboard', function () {
        return view('pasien.dashboard');
    })->name('pasien.dashboard');

    Route::get('/daftar', [PasienController::class, 'daftar'])
        ->name('pasien.daftar');
});