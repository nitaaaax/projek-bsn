<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContdataUmkm;   // controller baru
use App\Http\Controllers\SpjController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.index');

/* ---------- UMKM (multi‑step) ---------- */
Route::prefix('umkm')->name('umkm.')->group(function () {
    Route::get('/',                 [ContdataUmkm::class, 'index'])->name('index');

    /* step‑wise create */
    Route::get ('/create/step1',    [ContdataUmkm::class, 'createStep1'])->name('create.step1');
    Route::post('/store/step1',     [ContdataUmkm::class, 'storeStep1'])->name('store.step1');

    Route::get ('/create/step2/{id}', [ContdataUmkm::class, 'createStep2'])->name('create.step2');
    Route::post('/store/step2/{id}',  [ContdataUmkm::class, 'storeStep2'])->name('store.step2');

    // … ulangi Step 3‑6 jika diperlukan
});

/* ---------- SPJ (explicit routes, no resource) ---------- */
Route::get   ('/spj',          [SpjController::class, 'index' ])->name('spj.index');
Route::get   ('/spj/create',   [SpjController::class, 'create'])->name('spj.create');
Route::post  ('/spj',          [SpjController::class, 'store' ])->name('spj.store');
Route::get   ('/spj/{id}/edit',[SpjController::class, 'edit'  ])->name('spj.edit');
Route::put   ('/spj/{id}',     [SpjController::class, 'update'])->name('spj.update');
Route::delete('/spj/{id}',     [SpjController::class, 'destroy'])->name('spj.destroy');

Route::get('/spj/{id}', [SpjController::class, 'show'])->name('spj.show');
