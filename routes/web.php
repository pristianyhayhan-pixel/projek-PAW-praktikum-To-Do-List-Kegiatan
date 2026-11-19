<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KegiatanController;
use Illuminate\Support\Facades\Route;

// Halaman utama: dialihkan ke dashboard jika sudah login, atau ke login jika belum
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Rute untuk tamu yang belum login (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Rute untuk pengguna yang sudah login (Authenticated)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard dan Pengelolaan Kegiatan
    Route::get('/dashboard', [KegiatanController::class, 'index'])->name('dashboard');
    Route::get('/kegiatan/create', [KegiatanController::class, 'create'])->name('kegiatan.create');
    Route::post('/kegiatan', [KegiatanController::class, 'store'])->name('kegiatan.store');
    Route::get('/kegiatan/{id}/edit', [KegiatanController::class, 'edit'])->name('kegiatan.edit');
    Route::put('/kegiatan/{id}', [KegiatanController::class, 'update'])->name('kegiatan.update');
    Route::patch('/kegiatan/{id}/status', [KegiatanController::class, 'updateStatus'])->name('kegiatan.status');
    Route::delete('/kegiatan/{id}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');
});
