<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KaprodiController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Autentikasi & Registrasi
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');
    
    Route::post('/register', [RegisteredUserController::class, 'store']);

    // Lupa Password
    Route::get('/forgot-password', [PasswordResetController::class, 'create'])
        ->name('password.request');
    
    Route::post('/forgot-password', [PasswordResetController::class, 'store'])
        ->name('password.email');
});

// Fitur Setelah Login
Route::middleware('auth')->group(function() {
    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Dashboard
    Route::get('/dashboard', function() {
        $user = auth()->user();
        return redirect()->route($user->role . '.dashboard');
    })->name('dashboard');

    // Dashboard Role Spesifik
    Route::middleware(['role:admin'])->group(function() {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');
    });

    Route::middleware(['role:kaprodi'])->group(function() {
        Route::get('/kaprodi/dashboard', [KaprodiController::class, 'dashboard'])
            ->name('kaprodi.dashboard');
    });

    Route::middleware(['role:dosen'])->group(function() {
        Route::get('/dosen/dashboard', [DosenController::class, 'dashboard'])
            ->name('dosen.dashboard');
    });

    Route::middleware(['role:mahasiswa'])->group(function() {
        Route::get('/mahasiswa/dashboard', [MahasiswaController::class, 'dashboard'])
            ->name('mahasiswa.dashboard');
    });
    Route::put('/password', [PasswordUpdateController::class, 'update'])
->name('password.update');


});

// Email Verification
Route::middleware(['auth', 'signed'])->group(function () {
    Route::get('/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->name('verification.verify');
});

Route::middleware(['auth', 'throttle:6,1'])->group(function () {
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'sendVerificationLink'])
        ->name('verification.send');
});