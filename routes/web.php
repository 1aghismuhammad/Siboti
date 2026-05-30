<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PersonalTrainerDashboardController;
use App\Http\Controllers\PosDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReceptionistDashboardController;
use App\Http\Controllers\ReportPageController;
use App\Http\Controllers\ScanQrPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');

        case 'trainer':
            return redirect()->route('trainer.dashboard');

        case 'receptionist':
            return redirect()->route('receptionist.dashboard');

        default:
            return redirect()->route('member.dashboard');
    }
})->middleware('auth')->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('/admin', '/admin/dashboard');
    Route::get('/admin/dashboard', AdminDashboardController::class)->name('admin.dashboard');

    Route::get('/member/dashboard', function () {
        return view('member.dashboard');
    })->name('member.dashboard');

    Route::redirect('/trainer', '/trainer/dashboard');
    Route::get('/trainer/dashboard', PersonalTrainerDashboardController::class)->name('trainer.dashboard');

    Route::redirect('/receptionist', '/receptionist/dashboard');
    Route::get('/receptionist/dashboard', ReceptionistDashboardController::class)->name('receptionist.dashboard');

    Route::redirect('/pos', '/pos/dashboard');
    Route::get('/pos/dashboard', PosDashboardController::class)->name('pos.dashboard');

    Route::redirect('/scan-qr', '/scan-qr/check-in');
    Route::get('/scan-qr/check-in', ScanQrPageController::class)->name('scan-qr.index');

    Route::redirect('/reports', '/reports/dashboard');
    Route::get('/reports/dashboard', ReportPageController::class)->name('reports.index');

    Route::get('/admin/users', function () {
        $users = \App\Models\User::latest()->limit(50)->get();
        return view('admin.users.index', compact('users'));
    })->name('admin.users.index');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
