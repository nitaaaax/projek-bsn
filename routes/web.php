<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    ContdataUmkm,
    ContcreateUmkm,
    UMKMProsesController,
    UMKMSertifikasiController,
    SpjController,
    UmkmExportImportController
};

// ---------------- Redirect Default ----------------
Route::get('/', fn () => redirect()->route('login'));

// ---------------- Auth Routes ----------------
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'processLogin']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'processRegister']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ---------------- Admin Routes ----------------
Route::middleware(['auth', 'checkRole:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/home', [AuthController::class, 'home'])->name('home');

    // UMKM Management
    Route::prefix('umkm')->group(function () {
        Route::resource('/', ContdataUmkm::class)->only(['index', 'show', 'destroy']);
        Route::put('/{id}', [UMKMProsesController::class, 'update'])->name('umkm.update');
        Route::post('/{id}/sertifikasi', [UMKMProsesController::class, 'sertifikasi'])->name('umkm.sertifikasi');

        Route::prefix('create')->name('tahap.')->controller(ContcreateUmkm::class)->group(function () {
            Route::get('/', 'create')->name('create');
            Route::get('/tahap/{tahap}/{id?}', 'showTahap')->name('create.tahap');
            Route::post('/tahap/{tahap}/{id?}', 'store')->name('store');
        });
    });

    // UMKM Proses
    Route::prefix('umkm-proses')->name('umkm.proses.')->controller(UMKMProsesController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/export-word/{id}', 'exportWordPerUMKM')->name('exportWordPerUMKM');
    });

    Route::prefix('umkm-proses')->controller(UmkmExportImportController::class)->group(function () {
        Route::get('/export-word', 'exportWord')->name('umkm.proses.export.word');
        Route::post('/import-excel', 'importExcel')->name('umkm.proses.import.excel');
    });

    // Sertifikasi
    Route::prefix('umkm-sertifikasi')->name('umkm.sertifikasi.')->controller(UMKMSertifikasiController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
    });

    // SPJ
    Route::prefix('spj')->name('spj.')->controller(SpjController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/export', 'export')->name('export');
        Route::post('/import', 'import')->name('import');
    });
});

// ---------------- User Routes ----------------
Route::middleware(['auth', 'checkRole:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/home', [AuthController::class, 'home'])->name('home');

    Route::prefix('umkm')->group(function () {
        Route::resource('/', ContdataUmkm::class)->only(['index', 'show']);
    });
});
