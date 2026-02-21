<?php

use Illuminate\Support\Facades\Route;

/*
 |--------------------------------------------------------------------------
 | Web Routes
 |--------------------------------------------------------------------------
 */

// Landing Page
Route::get('/', [App\Http\Controllers\LandingController::class , 'index'])->name('landing');
Route::get('/features', [App\Http\Controllers\LandingController::class , 'features'])->name('landing.features');

// Authentication Routes
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class , 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class , 'login']);
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class , 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class , 'register']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class , 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class , 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class , 'sendResetLinkEmail'])->name('password.email');

// Public/Dev Route for simple access if Auth not fully scaffolded yet
Route::get('/dev-login', function () {
    return view('auth.login');
});

// Unified Admin & Staff Routes
Route::middleware(['web', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class , 'index'])->name('dashboard');
    Route::get('/dashboard/stats', [App\Http\Controllers\Admin\DashboardController::class , 'stats'])->name('dashboard.stats');

    // Protected Admin-Only Routes
    Route::middleware(['admin'])->group(function () {
            Route::resource('kelas', App\Http\Controllers\Admin\KelasController::class);
            Route::resource('jurusan', App\Http\Controllers\Admin\JurusanController::class);
            Route::resource('users', App\Http\Controllers\Admin\UserController::class);
            Route::post('/users/{id}/approve', [App\Http\Controllers\Admin\UserController::class , 'approve'])->name('users.approve');
            Route::get('/activity', [App\Http\Controllers\Admin\ActivityController::class , 'index'])->name('activity.index');
            Route::get('/activity/{id}', [App\Http\Controllers\Admin\ActivityController::class , 'show'])->name('activity.show');
            Route::get('/akademik/kenaikan', [App\Http\Controllers\Admin\AkademikController::class , 'index'])->name('akademik.index');
            Route::post('/akademik/proses', [App\Http\Controllers\Admin\AkademikController::class , 'process'])->name('akademik.process');
        }
        );

        // General Admin Panel Routes (Admin & User roles can access)
        Route::resource('santri', App\Http\Controllers\Admin\SantriController::class);
        Route::resource('sakit', App\Http\Controllers\Admin\SantriSakitController::class);
        Route::get('sakit/{id}/status/{status}', [App\Http\Controllers\Admin\SantriSakitController::class , 'setStatus'])->name('sakit.setStatus');
        Route::resource('obat', App\Http\Controllers\Admin\ObatController::class);
        Route::post('/obat/{id}/restock', [App\Http\Controllers\Admin\ObatController::class , 'restock'])->name('obat.restock');
        Route::get('/laporan', [App\Http\Controllers\Admin\LaporanController::class , 'index'])->name('laporan.index');
        Route::get('/laporan/export', [App\Http\Controllers\Admin\LaporanController::class , 'exportPdf'])->name('laporan.export');
    });

// User / Petugas Routes
Route::middleware(['web'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\User\UserDashboardController::class , 'index'])->name('dashboard');
    Route::post('/logout', [App\Http\Controllers\User\UserDashboardController::class , 'logout'])->name('logout');

    Route::get('/obat', function () {
            $obats = App\Models\Obat::where('stok', '>', 0)->get();
            return view('user.obat.list', compact('obats'));
        }
        )->name('obat.list');
        Route::post('/obat/{id}/use', [App\Http\Controllers\Admin\ObatController::class , 'handleUse'])->name('obat.use');

        Route::get('/form-sakit', [App\Http\Controllers\User\SantriSakitController::class , 'create'])->name('sakit.create');
        Route::post('/form-sakit', [App\Http\Controllers\User\SantriSakitController::class , 'store'])->name('sakit.store');
        Route::get('/history', [App\Http\Controllers\Admin\ActivityController::class , 'index'])->name('history');
    });

// Staff Routes (Petugas)
Route::middleware(['auth'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\StaffController::class , 'dashboard'])->name('dashboard');

    // Medicine Management
    Route::get('/obat', [App\Http\Controllers\StaffController::class , 'obatIndex'])->name('obat.index');
    Route::get('/obat/create', [App\Http\Controllers\StaffController::class , 'obatCreate'])->name('obat.create');
    Route::post('/obat', [App\Http\Controllers\StaffController::class , 'obatStore'])->name('obat.store');
    Route::get('/obat/{id}/edit', [App\Http\Controllers\StaffController::class , 'obatEdit'])->name('obat.edit');
    Route::put('/obat/{id}', [App\Http\Controllers\StaffController::class , 'obatUpdate'])->name('obat.update');
    Route::delete('/obat/{id}', [App\Http\Controllers\StaffController::class , 'obatDestroy'])->name('obat.destroy');

    // View Santri Data
    Route::get('/santri', [App\Http\Controllers\StaffController::class , 'santriIndex'])->name('santri.index');

    // Reports
    Route::get('/laporan', [App\Http\Controllers\StaffController::class , 'laporanIndex'])->name('laporan.index');
    Route::post('/laporan/generate', [App\Http\Controllers\StaffController::class , 'laporanGenerate'])->name('laporan.generate');
});

// Redirect /forms/sakit to the new user route for backward compatibility or remove
Route::get('/forms/sakit', function () {
    return redirect()->route('user.sakit.create');
});

// Remove Preview Routes for Production Launch
// Route::prefix('preview')->group(...) // Removed per user request "Jangan preview lagi"

// Profile & Shared Features
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class , 'index'])->name('profile.index');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class , 'update'])->name('profile.update');

    // Summary & Reminders
    Route::get('/api/summary', [App\Http\Controllers\Admin\SummaryController::class , 'getSummaryData'])->name('api.summary');
    Route::get('/api/reminders', [App\Http\Controllers\Admin\ReminderController::class , 'index'])->name('api.reminders.index');
    Route::post('/api/reminders', [App\Http\Controllers\Admin\ReminderController::class , 'store'])->name('api.reminders.store');
    Route::post('/api/reminders/{id}/dismiss', [App\Http\Controllers\Admin\ReminderController::class , 'dismiss'])->name('api.reminders.dismiss');
});