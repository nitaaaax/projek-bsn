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
    WilayahController, // ← KOMA SUDAH DITAMBAHKAN DI SINI
};

// ---------- AJAX Dropdown Kota , Provinsi ----------
Route::get('/get-kota/{provinsi}', [WilayahController::class, 'getKota']);


// ---------- Halaman Utama ----------
Route::get('/', [HomeController::class, 'index'])->name('home.index');

// ---------- Data UMKM (Proses + Detail) ----------
Route::resource('/umkm', ContdataUmkm::class)->only(['index', 'show', 'destroy']);
Route::put('/umkm/{id}', [UMKMProsesController::class, 'update'])->name('umkm.update');
Route::post('/umkm/{id}/sertifikasi', [UMKMProsesController::class, 'sertifikasi'])->name('umkm.sertifikasi');

// ---------- Wizard Input UMKM (Tahapan) ----------
Route::prefix('umkm')->name('tahap.')->controller(ContcreateUmkm::class)->group(function () {
    Route::get('/create', 'create')->name('create');
    Route::get('/create/tahap/{tahap}/{id?}', 'showTahap')->name('create.tahap');
    Route::post('/create/tahap/{tahap}/{id?}', 'store')->name('store');
});

// ---------- UMKM Proses ----------
Route::prefix('umkm-proses')->name('umkm.proses.')->group(function () {
    Route::get('/', [UMKMProsesController::class, 'index'])->name('index');
    Route::get('/export-word/{id}', [UMKMProsesController::class, 'exportWordPerUMKM'])->name('exportWordPerUMKM');
    Route::get('/export-word', [UmkmExportImportController::class, 'exportWord'])->name('export.word');
    Route::post('/import-excel', [UmkmExportImportController::class, 'importExcel'])->name('import.excel');
    Route::post('/', [UMKMProsesController::class, 'store'])->name('store');

});

// ---------- UMKM Sertifikasi ----------
Route::prefix('umkm-sertifikasi')->name('umkm.sertifikasi.')->group(function () {
    Route::get('/', [UMKMSertifikasiController::class, 'index'])->name('index');
    Route::get('/{id}/edit', [UMKMSertifikasiController::class, 'edit'])->name('edit');
    Route::put('/{id}', [UMKMSertifikasiController::class, 'update'])->name('update');
    Route::delete('/{id}', [UMKMSertifikasiController::class, 'destroy'])->name('destroy');
});


// ---------- SPJ ----------
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

Route::get('/tahap/{tahap}/detail/{id}', [ContdataUmkm::class, 'detailTahap'])->name('tahap.detail');

