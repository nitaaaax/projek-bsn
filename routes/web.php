<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    AuthController,
    ContdataUmkm,
    ContcreateUmkm,
    UMKMProsesController,
    UMKMSertifikasiController,
    SpjController,
    UmkmExportImportController,
    UserController,
    WilayahController
};

// ---------------------- PUBLIC (Guest) ----------------------
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'processRegister']);
    Route::post('/login', [AuthController::class, 'processLogin']);
});

// ---------------------- Redirect Default ----------------------
Route::get('/', fn () => redirect()->route('login'));

// ---------------------- LOGOUT ----------------------
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ---------------------- Home ----------------------
Route::middleware('auth')->get('/home', [HomeController::class, 'index'])->name('home');

// ---------------------- READ-ONLY USER DASHBOARD ----------------------
Route::middleware('auth')->group(function () {
    Route::get('/spj', [SpjController::class, 'index'])->name('spj.index');
    Route::get('/umkm-proses', [UMKMProsesController::class, 'index'])->name('umkm.proses.index');
    Route::get('/umkm-sertifikasi', [UMKMSertifikasiController::class, 'index'])->name('umkm.sertifikasi.index');
});

// --------------------- ADMIN ROUTES ---------------------
    Route::middleware(['auth', 'checkRole:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/dashboard', fn () => view('role.admin'))->name('dashboard');

    // UMKM Multi Tahap Proses
    Route::prefix('umkm-proses')->name('umkm.')->group(function () {
        Route::get('/', [ContcreateUmkm::class, 'index'])->name('index');
        Route::post('/import-excel', [UmkmExportImportController::class, 'importExcel'])->name('proses.import.excel');
        Route::get('/export/word', [UmkmExportImportController::class, 'exportWord'])->name('proses.export.word');

        Route::get('/create/{tahap}/{id?}', [ContcreateUmkm::class, 'create'])->name('create'); 
        Route::post('/store/{tahap}/{id?}', [ContcreateUmkm::class, 'store'])->name('store');

        Route::get('/{id}/edit', [ContdataUmkm::class, 'edit'])->name('edit');
        Route::delete('/{id}', [ContcreateUmkm::class, 'destroy'])->name('destroy');
        Route::get('/{id}', [ContdataUmkm::class, 'show'])->name('show');

        Route::get('/tahap/{tahap}', [UMKMProsesController::class, 'createTahap'])->name('create.tahap');
        Route::put('/tahap/update/{id}', [UMKMProsesController::class, 'update'])->name('tahap.update');
    });

    // Sertifikasi UMKM
    Route::prefix('umkm-sertifikasi')->name('sertifikasi.')->group(function () {
        Route::get('/', [UMKMSertifikasiController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [UMKMSertifikasiController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [UMKMSertifikasiController::class, 'update'])->name('update');
    });

    // SPJ
    Route::prefix('spj')->name('spj.')->group(function () {
        Route::get('/', [SpjController::class, 'index'])->name('index');
        Route::get('/create', [SpjController::class, 'create'])->name('create');
        Route::post('/store', [SpjController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [SpjController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [SpjController::class, 'update'])->name('update');
        Route::delete('/{id}', [SpjController::class, 'destroy'])->name('destroy');
        Route::get('/{id}', [SpjController::class, 'show'])->name('show');
        Route::get('/export', [SpjController::class, 'export'])->name('export');
        Route::post('/import', [SpjController::class, 'import'])->name('import');
    });

    });

    // --------------------- USER ROUTES ---------------------
    Route::prefix('user')->middleware(['auth', 'checkRole:user'])->name('user.')->group(function () {
        Route::get('/dashboard', fn () => view('role.user'))->name('dashboard');

        Route::prefix('umkm-proses')->name('umkm.')->group(function () {
            Route::get('/', [UMKMProsesController::class, 'index'])->name('index');
            Route::get('/{id}', [ContcreateUmkm::class, 'show'])->name('show');
        });
    });

     // Export & Import UMKM
    Route::get('/umkm/export-word/{id}', [UmkmExportImportController::class, 'exportWord'])->name('umkm.export.word.single');
    Route::post('/umkm/import-excel', [UmkmExportImportController::class, 'importExcel'])->name('umkm.import.excel');

// ---------------------- AJAX WILAYAH ----------------------
Route::get('/get-kota/{provinsi}', [WilayahController::class, 'getKota']);
