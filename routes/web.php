<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContdataUmkm;
use App\Http\Controllers\ContcreateUmkm;
use App\Http\Controllers\UMKMProsesController;
use App\Http\Controllers\UMKMSertifikasiController;
use App\Http\Controllers\SpjController;

/* ---------- Beranda ---------- */
Route::get('/', [HomeController::class, 'index'])->name('home.index');

/* ---------- Halaman Data UMKM ---------- */
Route::resource('/umkm', ContdataUmkm::class)->only(['index', 'show', 'destroy']);

// UMKM Proses (belum tersertifikasi)
Route::get('/umkm-proses', [UMKMProsesController::class, 'index'])->name('umkm.proses.index');

// Pindah status ke tersertifikasi
Route::post('/umkm/{id}/sertifikasi', [UMKMProsesController::class, 'sertifikasi'])->name('umkm.sertifikasi');

// UMKM Sertifikasi (sudah tersertifikasi)
Route::get('/umkm-sertifikasi', [UMKMSertifikasiController::class, 'index'])->name('umkm.sertifikasi.index');
Route::delete('/umkm-sertifikasi/{id}', [UMKMSertifikasiController::class, 'destroy'])->name('umkm.sertifikasi.destroy');

// Wizard Create UMKM (tahapan input)
Route::prefix('umkm')->name('tahap.')->controller(ContcreateUmkm::class)->group(function () {
    Route::get('/create', 'create')->name('create');
    Route::get('/create/tahap/{tahap}/{id?}', 'showTahap')->name('create.tahap');
    Route::post('/create/tahap/{tahap}/{id?}', 'store')->name('store');
});

/* ---------- SPJ ---------- */
Route::get('/spj', [SpjController::class, 'index'])->name('spj.index');
Route::get('/spj/create', [SpjController::class, 'create'])->name('spj.create');
Route::post('/spj', [SpjController::class, 'store'])->name('spj.store');
Route::get('/spj/{id}/edit', [SpjController::class, 'edit'])->name('spj.edit');
Route::put('/spj/{id}', [SpjController::class, 'update'])->name('spj.update');
Route::delete('/spj/{id}', [SpjController::class, 'destroy'])->name('spj.destroy');
Route::get('/spj/{id}', [SpjController::class, 'show'])->name('spj.show');
Route::get('/exportspj', [SpjController::class, 'spjexport'])->name('spj.export');
Route::post('/importspj', [SpjController::class, 'spjimportexcel'])->name('spj.import');

