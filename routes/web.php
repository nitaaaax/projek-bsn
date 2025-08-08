<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    AuthController,
    ContcreateUmkm,
    UMKMProsesController,
    UMKMSertifikasiController,
    SpjController,
    UmkmExportImportController,
    UserController,
    WilayahController,
};

    // ---------------------- GUEST ----------------------
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [AuthController::class, 'processRegister']);
        Route::post('/login', [AuthController::class, 'processLogin']);
    });

    // ---------------------- PROFILE ----------------------
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [UserController::class, 'profile'])->name('view');
        Route::post('/', [UserController::class, 'updateProfile'])->name('update');
    });

    // ---------------------- DEFAULT REDIRECT ----------------------
    Route::get('/', fn () => redirect()->route('login'));

    // ---------------------- LOGOUT ----------------------
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

    // ---------------------- HOME ----------------------
    Route::middleware('auth')->get('/home', [HomeController::class, 'index'])->name('home');

    // ---------------------- READ-ONLY USER DASHBOARD ----------------------
    Route::middleware('auth')->group(function () {
        Route::get('/spj', [SpjController::class, 'index'])->name('spj.index');
        Route::get('/spj/{id}', [SpjController::class, 'show'])->name('spj.show');
        Route::get('/umkm-proses', [UMKMProsesController::class, 'index'])->name('umkm.proses.index');
        Route::get('/umkm-sertifikasi', [UMKMSertifikasiController::class, 'index'])->name('umkm.sertifikasi.index');
    });

    // ---------------------- USER ROUTES (READ-ONLY + SHOW) ----------------------
    Route::prefix('user')->middleware(['auth', 'checkRole:user'])->name('user.')->group(function () {

        Route::prefix('umkm-proses')->name('umkm.')->group(function () {
            Route::get('/', [UMKMProsesController::class, 'index'])->name('index');
            Route::get('/spj/{id}', [SpjController::class, 'show'])->name('spj.show');
            Route::get('/{id}', [ContcreateUmkm::class, 'show'])->name('show');
            Route::delete('/{id}', [UMKMProsesController::class, 'destroy'])->name('destroy');

            Route::get('/tahap/{tahap}/{id?}', [UMKMProsesController::class, 'createTahap'])->name('create.tahap.user');
            Route::put('/tahap/update/{id}', [UMKMProsesController::class, 'update'])->name('tahap.update.user');
            Route::get('/detail/{id}', [UMKMProsesController::class, 'showUser'])->name('showuser');
        });

        Route::prefix('spj')->name('spj.')->group(function () {
            // Tidak perlu export di sini jika mau mandiri di luar prefix
            Route::get('/{id}', [SpjController::class, 'show'])->name('show');
        });
    });

    // ---------------------- ADMIN ROUTES ----------------------
    Route::middleware(['auth', 'checkRole:admin'])->prefix('admin')->name('admin.')->group(function () {

        Route::resource('users', UserController::class);
        Route::post('/users/{id}/update-role', [UserController::class, 'updateRole'])->name('users.updateRole');
        Route::post('/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');

        // UMKM Proses (Admin full akses Tahap 1 & 2)
        Route::prefix('umkm-proses')->name('umkm.')->group(function () {
            Route::get('/get-provinsi', [UMKMProsesController::class, 'getProvinsi'])->name('get.provinsi');
            Route::get('/get-kota/{provinsi_id}', [UMKMProsesController::class, 'getKota'])->name('get.kota');

            Route::get('/', [ContcreateUmkm::class, 'index'])->name('index');
            Route::get('/create', [ContcreateUmkm::class, 'create'])->name('create');
            Route::get('umkm/create/tahap/{tahap}/{id?}', [ContcreateUmkm::class, 'showTahap'])->name('create.tahap');
            Route::post('/store/{tahap}/{id?}', [ContcreateUmkm::class, 'store'])->name('store');

            Route::get('/{id}/edit', [UMKMProsesController::class, 'edit'])->name('edit');
            Route::delete('/{id}', [UMKMProsesController::class, 'destroy'])->name('destroy');
            Route::get('/{id}', [UMKMProsesController::class, 'show'])->name('show');

            Route::get('/tahap-form/{tahap}/{id?}', [UMKMProsesController::class, 'createTahap'])->name('create.tahap.form');
            Route::put('/tahap/update/{id}', [UMKMProsesController::class, 'update'])->name('tahap.update');

            // import excel
            Route::post('/import', [UmkmExportImportController::class, 'importExcel'])->name('import');
        });

        // UMKM Sertifikasi
        Route::prefix('umkm-sertifikasi')->name('sertifikasi.')->group(function () {
            Route::get('/', [UMKMSertifikasiController::class, 'index'])->name('index');
            Route::get('/{id}/edit', [UMKMSertifikasiController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [UMKMSertifikasiController::class, 'update'])->name('update');
            Route::delete('/{id}', [UMKMSertifikasiController::class, 'destroy'])->name('destroy');
        });

        // SPJ (Admin)
        Route::prefix('spj')->name('spj.')->group(function () {
            Route::get('/', [SpjController::class, 'index'])->name('index');
            Route::get('/create', [SpjController::class, 'create'])->name('create');
            Route::post('/store', [SpjController::class, 'store'])->name('store');
            Route::post('/import', [SpjController::class, 'import'])->name('import');

            Route::get('/{id}/edit', [SpjController::class, 'edit'])->name('edit');
            Route::get('/{id}', [SpjController::class, 'show'])->name('show');
            Route::put('/{id}/update', [SpjController::class, 'update'])->name('update');
            Route::delete('/{id}', [SpjController::class, 'destroy'])->name('destroy');
        });
    });

    // ---------------------- EXPORT SPJ MANDIRI ----------------------
    Route::middleware('auth')->group(function () {
        Route::get('/spj/export/{id}', [SpjController::class, 'export'])->name('spj.export');
    });

    // ---------------------- EXPORT UMKM ----------------------
    Route::get('/umkm/export-word/{id}', [UmkmExportImportController::class, 'exportWord'])->name('umkm.export.word.single');

    // ---------------------- EXPORT WORD SPJ ----------------------
    Route::get('/spj/downloadWord/{id}', [SpjController::class, 'downloadWord'])->name('downloadWord.spj');

    // Halaman daftar wilayah (misalnya daftar provinsi/kota)
    Route::get('/wilayah', [WilayahController::class, 'index'])->name('wilayah.index');

    // Proses penyimpanan data wilayah
    Route::post('/wilayah', [WilayahController::class, 'store'])->name('wilayah.store');

    // AJAX untuk ambil provinsi dan kota
    Route::get('/provinsi-kota', [WilayahController::class, 'getProvinsiKota'])->name('wilayah.getProvinsiKota');

    Route::resource('wilayah', WilayahController::class);
