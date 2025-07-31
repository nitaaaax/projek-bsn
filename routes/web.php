<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    ContdataUmkm,
    ContcreateUmkm,
    UMKMProsesController,
    UMKMSertifikasiController,
    SpjController,
    UmkmExportImportController,
    AuthController
};

// ---------- Auth ----------
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'processRegister']);
Route::post('/login', [AuthController::class, 'processLogin']);

// ---------- Home ----------
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

// ---------- UMKM ----------
Route::prefix('umkm')->name('umkm.')->middleware(['auth'])->group(function () {
    Route::get('/', [ContdataUmkm::class, 'index'])->name('index');
    Route::get('/create', [ContcreateUmkm::class, 'create'])->name('create');
    Route::post('/create', [ContcreateUmkm::class, 'store'])->name('store');
    Route::get('/{id}/edit', [UMKMProsesController::class, 'edit'])->name('edit');
    Route::put('/{id}', [UMKMProsesController::class, 'update'])->name('update');
    Route::get('/{id}/sertifikasi', [UMKMSertifikasiController::class, 'pindah'])->name('pindah');
});

// ---------- UMKM Sertifikasi ----------
Route::prefix('umkm-sertifikasi')->name('umkm.sertifikasi.')->middleware(['auth'])->group(function () {
    Route::get('/', [UMKMSertifikasiController::class, 'index'])->name('index');
    Route::get('/{id}/edit', [UMKMSertifikasiController::class, 'edit'])->name('edit');
    Route::put('/{id}', [UMKMSertifikasiController::class, 'update'])->name('update');
    Route::delete('/{id}', [UMKMSertifikasiController::class, 'destroy'])->name('destroy');
});

// ---------- SPJ ----------
Route::prefix('spj')->name('spj.')->middleware(['auth'])->group(function () {
    Route::get('/', [SpjController::class, 'index'])->name('index');
    Route::get('/create', [SpjController::class, 'create'])->name('create');
    Route::post('/create', [SpjController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [SpjController::class, 'edit'])->name('edit');
    Route::put('/{id}', [SpjController::class, 'update'])->name('update');
    Route::delete('/{id}', [SpjController::class, 'destroy'])->name('destroy');
    Route::get('/{id}', [SpjController::class, 'show'])->name('show');
});

// ---------- Import/Export ----------
Route::prefix('umkm-export')->name('umkm.export.')->middleware(['auth'])->group(function () {
    Route::get('/word', [UmkmExportImportController::class, 'exportWord'])->name('word');
    Route::post('/import', [UmkmExportImportController::class, 'importExcel'])->name('import');
});

// ---------------- Redirect Default ----------------
Route::get('/', fn () => redirect()->route('login'));
