<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\SantriController;
use App\Http\Controllers\Web\ObatController;
use App\Http\Controllers\Web\SakitController;
use App\Http\Controllers\Web\AdminController;
use App\Models\Santri;
use App\Models\SantriSakit;
use App\Models\Obat;

// Public
Route::get('/', function () { return view('welcome'); });
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $stats = [
            'total_santri' => Santri::count(),
            'total_sakit' => SantriSakit::where('status', 'Sakit')->count(),
            'total_sembuh' => SantriSakit::where('status', 'Sembuh')->count(),
            'low_stock' => Obat::whereColumn('stok', '<=', 'stok_minimum')->count(),
        ];
        return view('dashboard', compact('stats'));
    })->name('dashboard');

    // Management
    Route::resource('santris', SantriController::class)->names('santri');
    Route::resource('obats', ObatController::class)->names('obat');
    Route::resource('sakits', SakitController::class)->only(['index', 'create', 'store'])->names('sakit');
    Route::post('sakits/{sakit}/sembuh', [SakitController::class, 'markSembuh'])->name('sakit.sembuh');

    // Admin
    Route::get('/admin/registrations', [AdminController::class, 'registrations'])->name('admin.registrations');
    Route::post('/admin/registrations/{id}/approve', [AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/admin/registrations/{id}/reject', [AdminController::class, 'reject'])->name('admin.reject');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.user.destroy');
});
