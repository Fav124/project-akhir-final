<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\SantriController;
use App\Http\Controllers\Web\ObatController;
use App\Http\Controllers\Web\SakitController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\KelasController;
use App\Http\Controllers\Web\JurusanController;
use App\Http\Controllers\Web\DiagnosisController;
use App\Models\Santri;
use App\Models\SantriSakit;
use App\Models\Obat;

// Public
Route::get('/', function () { return view('welcome'); });
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected
// Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $total_santri = Santri::count();
        $santri_sakit = SantriSakit::where('status', 'Sakit')->count();
        $total_obat = Obat::count();
        $low_stock = Obat::whereColumn('stok', '<=', 'stok_minimum')->count();

        return view('dashboard', compact('total_santri', 'santri_sakit', 'total_obat', 'low_stock'));
    })->name('dashboard');



    // Analytics
    Route::get('/laporan', \App\Livewire\Laporan\LaporanIndex::class)->name('web.laporan.index');

    // Management
    Route::resource('santris', SantriController::class)->names('web.santri');
    Route::resource('obats', ObatController::class)->names('web.obat');
    Route::resource('sakits', SakitController::class)->only(['index', 'create', 'store'])->names('web.sakit');
    Route::post('sakits/{sakit}/sembuh', [SakitController::class, 'markSembuh'])->name('web.sakit.sembuh');

    // Master Data Hub
    Route::get('/master-hub', \App\Livewire\Master\MasterDataHub::class)->name('web.master.hub');

    Route::resource('kelas', KelasController::class)->names('web.kelas');
    Route::resource('jurusans', JurusanController::class)->names('web.jurusan');
    Route::resource('diagnoses', DiagnosisController::class)->names('web.diagnosis');

    // Admin
    Route::get('/admin/registrations', [AdminController::class, 'registrations'])->name('web.admin.registrations');
    Route::post('/admin/registrations/{id}/approve', [AdminController::class, 'approve'])->name('web.admin.approve');
    Route::post('/admin/registrations/{id}/reject', [AdminController::class, 'reject'])->name('web.admin.reject');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('web.admin.users');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('web.admin.user.destroy');
// });
