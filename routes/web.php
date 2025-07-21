<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    ContdataUmkm,
    ContcreateUmkm,
    UMKMProsesController,
    UMKMSertifikasiController,
    SpjController,
    UmkmExportImportController
};

// ---------- Beranda ----------
Route::get('/', [HomeController::class, 'index'])->name('home.index');

// ---------- Data UMKM ----------
Route::resource('/umkm', ContdataUmkm::class)->only(['index', 'show', 'destroy']);
Route::put('/umkm/{id}', [UMKMProsesController::class, 'update'])->name('umkm.update');
Route::post('/umkm/{id}/sertifikasi', [UMKMProsesController::class, 'sertifikasi'])->name('umkm.sertifikasi');

// ---------- UMKM Proses ----------
Route::get('/umkm-proses', [UMKMProsesController::class, 'index'])->name('umkm.proses.index');
Route::get('/umkm-proses/export-word/{id}', [UMKMProsesController::class, 'exportWordPerUMKM'])->name('umkm.proses.exportWordPerUMKM');

// ---------- UMKM Sertifikasi ----------
Route::get('/umkm-sertifikasi', [UMKMSertifikasiController::class, 'index'])->name('umkm.sertifikasi.index');
Route::delete('/umkm-sertifikasi/{id}', [UMKMSertifikasiController::class, 'destroy'])->name('umkm.sertifikasi.destroy');
Route::get('/sertifikasi/{id}/edit', [UMKMSertifikasiController::class, 'edit'])->name('sertifikasi.edit');
Route::put('/sertifikasi/{id}', [UMKMSertifikasiController::class, 'update'])->name('sertifikasi.update');

// ---------- Tahapan Create UMKM (Form Wizard) ----------
Route::prefix('umkm')->name('tahap.')->controller(ContcreateUmkm::class)->group(function () {
    Route::get('/create', 'create')->name('create');
    Route::get('/create/tahap/{tahap}/{id?}', 'showTahap')->name('create.tahap');
    Route::post('/create/tahap/{tahap}/{id?}', 'store')->name('store');
});

// ---------- Import/Export UMKM ----------
Route::prefix('umkm-proses')->name('umkm.proses.')->controller(UmkmExportImportController::class)->group(function () {
    Route::get('/export-word', 'exportWord')->name('export.word');
    Route::post('/import-excel', 'importExcel')->name('import.excel');
});


// ---------- SPJ ----------
Route::get('/spj', [SpjController::class, 'index'])->name('spj.index');
Route::get('/spj/create', [SpjController::class, 'create'])->name('spj.create');
Route::post('/spj', [SpjController::class, 'store'])->name('spj.store');
Route::get('/spj/{id}/edit', [SpjController::class, 'edit'])->name('spj.edit');
Route::put('/spj/{id}', [SpjController::class, 'update'])->name('spj.update');
Route::delete('/spj/{id}', [SpjController::class, 'destroy'])->name('spj.destroy');
Route::get('/spj/{id}', [SpjController::class, 'show'])->name('spj.show');
Route::get('/spj/export', [SpjController::class, 'export'])->name('spj.export');
Route::post('/spj/import', [SpjController::class, 'import'])->name('spj.import');

