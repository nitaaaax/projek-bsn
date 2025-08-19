<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    AuthController,
    ContcreateUmkm,
    UMKMProsesController,
    UMKMSertifikasiController,
    SpjController,
    ExportImportController,
    UserController,
    WilayahController,
    ErrorController,
};

// ---------------------- GUEST ----------------------
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'processRegister']);
    Route::post('/login', [AuthController::class, 'processLogin']);
});

// ---------------------- PROFILE ----------------------
Route::prefix('profile')->middleware('auth')->name('profile.')->group(function () {
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

// ---------------------- USER ROUTES ----------------------
Route::prefix('user')->middleware(['auth', 'checkRole:user'])->name('user.')->group(function () {
    Route::prefix('umkm-proses')->name('umkm.')->group(function () {
        Route::get('/', [UMKMProsesController::class, 'index'])->name('index');
        Route::get('/spj/{id}', [SpjController::class, 'show'])->name('spj.show');

        // Detail route dipisah dari {id}
        Route::get('/detail/{id}', [UMKMProsesController::class, 'showUser'])->name('showuser');

        Route::get('/{id}', [ContcreateUmkm::class, 'show'])->name('show');
        Route::delete('/{id}', [UMKMProsesController::class, 'destroy'])->name('destroy');

        Route::get('/tahap/{tahap}/{id?}', [UMKMProsesController::class, 'createTahap'])->name('create.tahap.user');
        Route::put('/tahap/update/{id}', [UMKMProsesController::class, 'update'])->name('tahap.update.user');
    });
});

// ---------------------- ADMIN ROUTES ----------------------
Route::middleware(['auth', 'checkRole:admin'])->prefix('admin')->name('admin.')->group(function () {

    // User Management
    Route::resource('users', UserController::class);
    Route::post('/users/{id}/update-role', [UserController::class, 'updateRole'])->name('users.updateRole');
    Route::post('/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');

    // UMKM Proses
    Route::prefix('umkm-proses')->name('umkm.')->group(function () {
        Route::get('/get-provinsi', [UMKMProsesController::class, 'getProvinsi'])->name('get.provinsi');
        Route::get('/get-kota/{provinsi_id}', [UMKMProsesController::class, 'getKota'])->name('get.kota');

        Route::get('/', [ContcreateUmkm::class, 'index'])->name('index');
        Route::get('/create', [ContcreateUmkm::class, 'show'])->name('create');
        Route::post('/store', [ContcreateUmkm::class, 'store'])->name('store');

        Route::get('/{id}/edit', [UMKMProsesController::class, 'edit'])->name('edit');
        Route::get('/{id}', [UMKMProsesController::class, 'show'])->name('show');
        Route::put('/update/{id}', [UMKMProsesController::class, 'update'])->name('update');
        Route::delete('/{id}', [UMKMProsesController::class, 'destroy'])->name('destroy');

        Route::post('/import', [ExportImportController::class, 'importUmkm'])->name('import');
        Route::get('templates/{filename}/view', [ExportImportController::class, 'view'])->name('templates.view');
    });

    // UMKM Sertifikasi
    Route::prefix('umkm-sertifikasi')->name('sertifikasi.')->group(function () {
        Route::get('/', [UMKMSertifikasiController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [UMKMSertifikasiController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [UMKMSertifikasiController::class, 'update'])->name('update');
        Route::delete('/{id}', [UMKMSertifikasiController::class, 'destroy'])->name('destroy');
    });

    // SPJ Management
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

    // Template Management
    Route::prefix('templates')->name('templates.')->group(function () {
        Route::get('/', [ExportImportController::class, 'index'])->name('index');
        Route::post('/', [ExportImportController::class, 'store'])->name('store');
        Route::put('/{filename}', [ExportImportController::class, 'update'])->name('update');
        Route::delete('/{filename}', [ExportImportController::class, 'destroy'])->name('destroy');
    });
});

    // ---------------------- EXPORT ----------------------
    Route::middleware('auth')->group(function () {
        Route::get('/spj/export/{id}', [SpjController::class, 'export'])->name('spj.export');
});
    Route::get('/umkm/export-umkm/{id}', [ExportImportController::class, 'exportUmkm'])->name('umkm.export.word.single');
    Route::get('/spj/export-spj/{id}', [ExportImportController::class, 'exportSpj'])->name('downloadWord.spj');

    // ---------------------- WILAYAH ----------------------
    Route::get('/wilayah', [WilayahController::class, 'index'])->name('wilayah.index');
    Route::post('/wilayah', [WilayahController::class, 'store'])->name('wilayah.store');
    Route::get('/provinsi-kota', [WilayahController::class, 'getProvinsiKota'])->name('wilayah.getProvinsiKota');
    Route::resource('wilayah', WilayahController::class);

    // ---------------------- ERROR HANDLING ----------------------
    Route::get('/403', [ErrorController::class, 'forbidden'])->name('error.403'); // 403 Forbidden
    Route::fallback([ErrorController::class, 'notFound']); // 404 Not Found
