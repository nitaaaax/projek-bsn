<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpjController;



Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::resource('spj', SpjController::class);

// Route::get('/spj', [SpjController::class, 'index'])->name('spj.index');

// Route::get('/spj/create', [SpjController::class, 'create'])->name('spj.create');
// Route::post('/spj', [SpjController::class, 'store'])->name('spj.store');
// Route::get('/spj/{id}/edit', [SpjController::class, 'edit'])->name('spj.edit');
// Route::put('/spj/{id}', [SpjController::class, 'update'])->name('spj.update');
// Route::delete('/spj/{id}', [SpjController::class, 'destroy'])->name('spj.destroy');
