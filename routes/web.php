<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\HubBookingController;
use App\Http\Controllers\HubDashboardController;
use App\Http\Controllers\HubProgressController;
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
    })->middleware(['auth', EnsureUserRole::class . ':member'])->name('member.dashboard');

// SibotiHUB
Route::get('/hub/dashboard', [HubDashboardController::class, 'dashboard'])
    ->middleware(['auth', EnsureUserRole::class . ':member'])
    ->name('hub.dashboard');

Route::get('/hub/qr', [HubDashboardController::class, 'qr'])
    ->middleware(['auth', EnsureUserRole::class . ':member'])
    ->name('hub.qr');

Route::get('/hub/progress', [HubProgressController::class, 'index'])
    ->middleware(['auth', EnsureUserRole::class . ':member'])
    ->name('hub.progress');

Route::get('/hub/booking', [HubBookingController::class, 'index'])
    ->middleware(['auth', EnsureUserRole::class . ':member'])
    ->name('hub.booking');

Route::post('/hub/bookings', [HubBookingController::class, 'store'])
    ->middleware(['auth', EnsureUserRole::class . ':member'])
    ->name('hub.bookings.store');

Route::delete('/hub/bookings/{booking}', [HubBookingController::class, 'destroy'])
    ->middleware(['auth', EnsureUserRole::class . ':member'])
    ->name('hub.bookings.destroy');

Route::get('/hub/membership/{plan_id}/buy', [\App\Http\Controllers\HubMembershipController::class, 'buy'])
    ->middleware(['auth', EnsureUserRole::class . ':member'])
    ->name('hub.membership.buy');

// Admin / Role dashboards (use controllers)
Route::get('/admin/dashboard', AdminDashboardController::class)
    ->middleware(['auth', EnsureUserRole::class . ':admin'])
    ->name('admin.dashboard');

Route::prefix('admin')->middleware(['auth', EnsureUserRole::class . ':admin'])->name('admin.')->group(function () {
    Route::get('/memberships', [\App\Http\Controllers\AdminPageController::class, 'memberships'])->name('memberships');
    Route::get('/trainers', [\App\Http\Controllers\AdminPageController::class, 'trainers'])->name('trainers');
    Route::get('/bookings', [\App\Http\Controllers\AdminPageController::class, 'bookings'])->name('bookings');
    Route::get('/reports', [\App\Http\Controllers\AdminPageController::class, 'reports'])->name('reports');
    Route::get('/maintenance', [\App\Http\Controllers\AdminPageController::class, 'maintenance'])->name('maintenance');
    
    // Admin Actions
    Route::post('/subscriptions/{id}/approve', [\App\Http\Controllers\AdminPageController::class, 'approveSubscription'])->name('subscriptions.approve');
    Route::post('/bookings/{id}/forward', [\App\Http\Controllers\AdminPageController::class, 'forwardBooking'])->name('bookings.forward');
    
    // Trainer CRUD
    Route::post('/trainers', [\App\Http\Controllers\AdminPageController::class, 'storeTrainer'])->name('trainers.store');
    Route::put('/trainers/{id}', [\App\Http\Controllers\AdminPageController::class, 'updateTrainer'])->name('trainers.update');
    Route::delete('/trainers/{id}', [\App\Http\Controllers\AdminPageController::class, 'destroyTrainer'])->name('trainers.destroy');
});

Route::get('/trainer/dashboard', PersonalTrainerDashboardController::class)
    ->middleware(['auth', EnsureUserRole::class . ':trainer'])
    ->name('trainer.dashboard');

Route::patch('/trainer/bookings/{booking}', [PersonalTrainerDashboardController::class, 'updateBookingStatus'])
    ->middleware(['auth', EnsureUserRole::class . ':trainer'])
    ->name('trainer.bookings.update');

Route::get('/receptionist/dashboard', ReceptionistDashboardController::class)
    ->middleware(['auth', EnsureUserRole::class . ':receptionist'])
    ->name('receptionist.dashboard');

Route::get('/scan-qr', ScanQrPageController::class)
    ->middleware(['auth', EnsureUserRole::class . ':receptionist'])
    ->name('scan-qr.index');

Route::get('/pos/dashboard', PosDashboardController::class)
    ->middleware(['auth', EnsureUserRole::class . ':receptionist'])
    ->name('pos.dashboard');

Route::get('/pos/history', PosHistoryController::class)
    ->middleware('auth')
    ->name('pos.history');

Route::get('/reports', ReportPageController::class)
    ->middleware(['auth', EnsureUserRole::class . ':admin'])
    ->name('reports.index');

// Trainer Panel (legacy views for trainer auth/register pages)
// Trainer login — pakai auth controller yang sama
Route::get('/trainer/login', [AuthenticatedSessionController::class, 'create'])
    ->name('trainer.login');
Route::post('/trainer/login', [AuthenticatedSessionController::class, 'store']);

// Tambahkan ini
Route::post('/scan-qr/checkin', [ScanQrPageController::class, 'checkin'])
    ->middleware(['auth', EnsureUserRole::class . ':receptionist'])
    ->name('scan-qr.checkin');