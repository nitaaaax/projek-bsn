<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContdataUmkm;    // daftar & detail
use App\Http\Controllers\ContcreateUmkm; // wizard 6‑tahap
use App\Http\Controllers\SpjController;

/* ---------- Home ---------- */
Route::get('/', [HomeController::class, 'index'])->name('home.index');

/* ---------- Halaman Data UMKM ---------- */
Route::get('/umkm', [ContdataUmkm::class, 'index'])->name('umkm.index');

Route::get('/umkm/{id}', [ContdataUmkm::class, 'show'])->name('umkm.show');


/* ---------- Wizard Tahapan UMKM ---------- */
Route::prefix('tahap')
    ->name('tahap.')
    ->controller(ContcreateUmkm::class)
    ->group(function () {

    // Mulai create → langsung redirect ke tahap 1
    Route::get('/create', 'create')->name('create');

    // Tampilkan form per tahap
    Route::get('/create/{tahap}/{id?}', 'showTahap')->name('create.tahap');

    // Simpan data per tahap (satu store dinamis)
    Route::post('/store/{tahap}/{id?}', 'store')->name('store.tahap');
});

/* ---------- SPJ ---------- */
Route::get   ('/spj',          [SpjController::class, 'index' ])->name('spj.index');
Route::get   ('/spj/create',   [SpjController::class, 'create'])->name('spj.create');
Route::post  ('/spj',          [SpjController::class, 'store' ])->name('spj.store');
Route::get   ('/spj/{id}/edit',[SpjController::class, 'edit'  ])->name('spj.edit');
Route::put   ('/spj/{id}',     [SpjController::class, 'update'])->name('spj.update');
Route::delete('/spj/{id}',     [SpjController::class, 'destroy'])->name('spj.destroy');
Route::get   ('/spj/{id}',     [SpjController::class, 'show' ])->name('spj.show');
