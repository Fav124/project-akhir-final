<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Public/Dev Route for simple access if Auth not fully scaffolded yet
Route::get('/dev-login', function () {
    return view('auth.login');
});

// Admin Routes
Route::middleware(['web'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Protected Admin-Only Routes
    Route::middleware(['admin'])->group(function () {
        Route::resource('kelas', App\Http\Controllers\Admin\KelasController::class);
        Route::resource('jurusan', App\Http\Controllers\Admin\JurusanController::class);
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::post('/users/{id}/approve', [App\Http\Controllers\Admin\UserController::class, 'approve'])->name('users.approve');
        Route::get('/activity', [App\Http\Controllers\Admin\ActivityController::class, 'index'])->name('activity.index');
        Route::get('/activity/{id}', [App\Http\Controllers\Admin\ActivityController::class, 'show'])->name('activity.show');
    });

    // General Admin Panel Routes (Admin & User roles can access)
    Route::resource('santri', App\Http\Controllers\Admin\SantriController::class);
    Route::resource('sakit', App\Http\Controllers\Admin\SantriSakitController::class);
    Route::get('sakit/{id}/status/{status}', [App\Http\Controllers\Admin\SantriSakitController::class, 'setStatus'])->name('sakit.setStatus');
    Route::resource('obat', App\Http\Controllers\Admin\ObatController::class);
    Route::post('/obat/{id}/restock', [App\Http\Controllers\Admin\ObatController::class, 'restock'])->name('obat.restock');
    Route::get('/laporan', [App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [App\Http\Controllers\Admin\LaporanController::class, 'exportPdf'])->name('laporan.export');
});

// User / Petugas Routes
Route::middleware(['web'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\User\UserDashboardController::class, 'index'])->name('dashboard');

    Route::get('/obat', function () {
        // Simple view, could be moved to controller if logic needed later
        // But for now it's mostly client-side interactive via API or basic list
        // Let's use a simple controller method or keep closure if data passed
        // For list.blade.php to work, it needs obats. Let's make a mini controller method inline or use ObatController
        $obats = App\Models\Obat::where('stok', '>', 0)->get();
        return view('user.obat.list', compact('obats'));
    })->name('obat.list');

    Route::get('/form-sakit', [App\Http\Controllers\User\SantriSakitController::class, 'create'])->name('sakit.create');
    Route::post('/form-sakit', [App\Http\Controllers\User\SantriSakitController::class, 'store'])->name('sakit.store');
});

// Redirect /forms/sakit to the new user route for backward compatibility or remove
Route::get('/forms/sakit', function () {
    return redirect()->route('user.sakit.create');
});

// Remove Preview Routes for Production Launch
// Route::prefix('preview')->group(...) // Removed per user request "Jangan preview lagi"

// Profile Settings
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
