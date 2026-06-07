<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PersonalTrainerDashboardController;
use App\Http\Controllers\PosDashboardController;
use App\Http\Controllers\PosHistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReceptionistDashboardController;
use App\Http\Controllers\ReportPageController;
use App\Http\Controllers\ScanQrPageController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Middleware\EnsureUserRole;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Auth (use controllers)
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Generic dashboard redirect (named for registration redirect)
Route::get('/dashboard', function () {
    $user = auth()->user();
    if (! $user) {
        return redirect()->route('login');
    }

    switch ($user->role) {
        case 'admin':
            return redirect('/admin/dashboard');
        case 'trainer':
            return redirect('/trainer/dashboard');
        case 'receptionist':
            return redirect('/receptionist/dashboard');
            default:
                // Members land on the public hub dashboard
                return redirect('/hub/dashboard');
    }
})->middleware('auth')->name('dashboard');

    // Member dashboard (simple placeholder)
    Route::get('/member/dashboard', function () {
        return view('member.dashboard');
    })->middleware('auth')->name('member.dashboard');

// SibotiHUB
Route::get('/hub/dashboard', function () {
    return view('hub.dashboard');
});

Route::get('/hub/qr', function () {
    return view('hub.qr');
});

Route::get('/hub/progress', function () {
    return view('hub.progress');
});

Route::get('/hub/booking', function () {
    return view('hub.booking');
});

// Admin / Role dashboards (use controllers)
Route::get('/admin/dashboard', AdminDashboardController::class)
    ->middleware('auth')
    ->name('admin.dashboard');

Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('/memberships', [\App\Http\Controllers\AdminPageController::class, 'memberships'])->name('memberships');
    Route::get('/trainers', [\App\Http\Controllers\AdminPageController::class, 'trainers'])->name('trainers');
    Route::get('/bookings', [\App\Http\Controllers\AdminPageController::class, 'bookings'])->name('bookings');
    Route::get('/reports', [\App\Http\Controllers\AdminPageController::class, 'reports'])->name('reports');
    Route::get('/maintenance', [\App\Http\Controllers\AdminPageController::class, 'maintenance'])->name('maintenance');
});

Route::get('/trainer/dashboard', PersonalTrainerDashboardController::class)
    ->middleware('auth')
    ->name('trainer.dashboard');

Route::get('/receptionist/dashboard', ReceptionistDashboardController::class)
    ->middleware('auth')
    ->name('receptionist.dashboard');

Route::get('/scan-qr', ScanQrPageController::class)
    ->middleware('auth')
    ->name('scan-qr.index');

Route::get('/pos/dashboard', PosDashboardController::class)
    ->middleware('auth')
    ->name('pos.dashboard');

Route::get('/pos/history', PosHistoryController::class)
    ->middleware('auth')
    ->name('pos.history');

Route::get('/reports', ReportPageController::class)
    ->middleware('auth')
    ->name('reports.index');

// Trainer Panel (legacy views for trainer auth/register pages)
// Trainer login — pakai auth controller yang sama
Route::get('/trainer/login', [AuthenticatedSessionController::class, 'create'])
    ->name('trainer.login');
Route::post('/trainer/login', [AuthenticatedSessionController::class, 'store']);

Route::get('/scan-qr', ScanQrPageController::class)
    ->middleware('auth')
    ->name('scan-qr.index');

// Tambahkan ini
Route::post('/scan-qr/checkin', [ScanQrPageController::class, 'checkin'])
    ->middleware('auth')
    ->name('scan-qr.checkin');