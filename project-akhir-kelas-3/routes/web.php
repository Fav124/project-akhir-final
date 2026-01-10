<?php

use App\Http\Controllers\{
    DashboardController,
    SantriController,
    KelasController,
    SakitController,
    ObatController,
    LaporanController,
    UserController,
    JurusanController,
    DiagnosisController,
    HistoryController
};
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));

// Auth Routes
Route::get('login', [LoginController::class, 'showLogin'])->name('login');
Route::post('login', [LoginController::class, 'authenticate']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('coba', [DashboardController::class, 'coba'])->name('coba');

/*
|--------------------------------------------------------------------------
| USER MANAGEMENT (Admin Only)
|--------------------------------------------------------------------------
*/
Route::prefix('users')->name('users.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    Route::post('/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('toggleActive');
});

/*
|--------------------------------------------------------------------------
| JURUSAN
|--------------------------------------------------------------------------
*/
Route::prefix('jurusan')->name('jurusan.')->middleware('auth')->group(function () {
    Route::get('/', [JurusanController::class, 'index'])->name('index');
    Route::get('/create', [JurusanController::class, 'create'])->name('create');
    Route::post('/', [JurusanController::class, 'store'])->name('store');
    Route::get('/{jurusan}/edit', [JurusanController::class, 'edit'])->name('edit');
    Route::put('/{jurusan}', [JurusanController::class, 'update'])->name('update');
    Route::delete('/{jurusan}', [JurusanController::class, 'destroy'])->name('destroy');
});

/*
|--------------------------------------------------------------------------
| SANTRI
|--------------------------------------------------------------------------
*/
Route::prefix('santri')->name('santri.')->group(function () {
    Route::get('/', [SantriController::class, 'index'])->name('index');
    Route::get('/create', [SantriController::class, 'create'])->name('create');
    // Search API for typeahead
    Route::get('/search', [SantriController::class, 'search'])->name('search');
    Route::get('/get-jurusans', [SantriController::class, 'getJurusansByKelas'])->name('getJurusans');
    Route::get('/get-by-filter', [SantriController::class, 'getSantriByFilter'])->name('getSantriByFilter');
    Route::post('/save', [SantriController::class, 'save'])->name('save');

    // 🔥 AUTOSAVE
    Route::post('/autosave', [SantriController::class, 'storeTemporary'])->name('autosave');
    Route::get('/getTemporary', [SantriController::class, 'getTemporary'])->name('getTemporary');
    Route::delete('/deleteTemporary', [SantriController::class, 'deleteTemporary'])->name('deleteTemporary');

    // 🔥 SIMPAN SEMUA TEMPORARY KE DATABASE
    Route::post('/saveAll', [SantriController::class, 'saveAll'])->name('saveAll');

    Route::get('/{santri}/edit', [SantriController::class, 'edit'])->name('edit');
    Route::put('/{santri}', [SantriController::class, 'update'])->name('update');
    Route::get('/{santri}', [SantriController::class, 'show'])->name('show');
    Route::delete('/{santri}', [SantriController::class, 'destroy'])->name('destroy');

    // 🔥 UPDATE DRAFT
    Route::put('/updateTemporary', [SantriController::class, 'updateTemporary'])->name('updateTemporary');
});



/*
|--------------------------------------------------------------------------
| KELAS
|--------------------------------------------------------------------------
*/
Route::prefix('kelas')->name('kelas.')->group(function () {
    Route::get('/', [KelasController::class, 'index'])->name('index');
    Route::get('/create', [KelasController::class, 'create'])->name('create');
    Route::post('/', [KelasController::class, 'store'])->name('store');
    Route::get('/{kela}/edit', [KelasController::class, 'edit'])->name('edit');
    Route::put('/{kela}', [KelasController::class, 'update'])->name('update');
    Route::delete('/{kela}', [KelasController::class, 'destroy'])->name('destroy');
});

/*
|--------------------------------------------------------------------------
| DIAGNOSIS (Admin for CRUD, All for Search)
|--------------------------------------------------------------------------
*/
Route::prefix('diagnosis')->name('diagnosis.')->group(function () {
    Route::get('/search', [DiagnosisController::class, 'search'])->name('search');
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/', [DiagnosisController::class, 'index'])->name('index');
        Route::post('/', [DiagnosisController::class, 'store'])->name('store');
        Route::put('/{diagnosis}', [DiagnosisController::class, 'update'])->name('update');
        Route::delete('/{diagnosis}', [DiagnosisController::class, 'destroy'])->name('destroy');
    });
});

/*
|--------------------------------------------------------------------------
| SANTRI SAKIT
|--------------------------------------------------------------------------
*/
Route::prefix('sakit')->name('sakit.')->group(function () {
    Route::get('/', [SakitController::class, 'index'])->name('index');
    Route::get('/create', [SakitController::class, 'create'])->name('create');

    // Draft Routes
    Route::post('/storeTemporary', [SakitController::class, 'storeTemporary'])->name('storeTemporary');
    Route::get('/getTemporary', [SakitController::class, 'getTemporary'])->name('getTemporary');
    Route::put('/updateTemporary', [SakitController::class, 'updateTemporary'])->name('updateTemporary');
    Route::delete('/deleteTemporary', [SakitController::class, 'deleteTemporary'])->name('deleteTemporary');
    Route::post('/saveAll', [SakitController::class, 'saveAll'])->name('saveAll');

    Route::post('/', [SakitController::class, 'store'])->name('store');
    Route::get('/{sakit}/edit', [SakitController::class, 'edit'])->name('edit');
    Route::put('/{sakit}', [SakitController::class, 'update'])->name('update');
    Route::get('/{sakit}', [SakitController::class, 'show'])->name('show');
    // Mark as recovered
    Route::put('/{sakit}/sembuh', [SakitController::class, 'markRecovered'])->name('sembuh');
    
    // Quick Medicine Routes
    Route::get('/{sakit}/medicines', [SakitController::class, 'getMedicines'])->name('getMedicines');
    Route::post('/{sakit}/medicines', [SakitController::class, 'syncMedicines'])->name('syncMedicines');

    Route::delete('/{sakit}', [SakitController::class, 'destroy'])->name('destroy');
});

/*
|--------------------------------------------------------------------------
| OBAT
|--------------------------------------------------------------------------
*/
Route::prefix('obat')->name('obat.')->group(function () {
    Route::get('/', [ObatController::class, 'index'])->name('index');
    Route::get('/create', [ObatController::class, 'create'])->name('create');

    // Draft Routes
    Route::post('/storeTemporary', [ObatController::class, 'storeTemporary'])->name('storeTemporary');
    Route::get('/getTemporary', [ObatController::class, 'getTemporary'])->name('getTemporary');
    Route::put('/updateTemporary', [ObatController::class, 'updateTemporary'])->name('updateTemporary');
    Route::delete('/deleteTemporary', [ObatController::class, 'deleteTemporary'])->name('deleteTemporary');
    Route::post('/saveAll', [ObatController::class, 'saveAll'])->name('saveAll');

    // Stock Check
    Route::get('/check-stock', [ObatController::class, 'checkStock'])->name('checkStock');

    Route::post('/', [ObatController::class, 'store'])->name('store');
    Route::get('/{obat}/edit', [ObatController::class, 'edit'])->name('edit');
    Route::put('/{obat}', [ObatController::class, 'update'])->name('update');
    Route::get('/{obat}', [ObatController::class, 'show'])->name('show');
    Route::delete('/{obat}', [ObatController::class, 'destroy'])->name('destroy');
});

/*
|--------------------------------------------------------------------------
| LAPORAN
|--------------------------------------------------------------------------
*/
Route::prefix('laporan')->name('laporan.')->group(function () {
    Route::get('/', [LaporanController::class, 'index'])->name('index');
    Route::get('/create', [LaporanController::class, 'create'])->name('create');
    // Report / Summary view
    Route::get('/report', [LaporanController::class, 'report'])->name('report');
    Route::get('/report/pdf', [LaporanController::class, 'reportPdf'])->name('report.pdf');
    Route::post('/', [LaporanController::class, 'store'])->name('store');
    Route::get('/{laporan}/edit', [LaporanController::class, 'edit'])->name('edit');
    Route::put('/{laporan}', [LaporanController::class, 'update'])->name('update');
    Route::delete('/{laporan}', [LaporanController::class, 'destroy'])->name('destroy');
});

Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
