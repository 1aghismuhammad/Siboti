<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PersonalTrainerDashboardController;
use App\Http\Controllers\PosDashboardController;
use App\Http\Controllers\ProgressRecordController;
use App\Http\Controllers\ReceptionistDashboardController;
use App\Http\Controllers\ReportPageController;
use App\Http\Controllers\ScanQrPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/member/dashboard', function () {
        return view('member.dashboard');
    })->middleware('ensureUserRole:member')
      ->name('member.dashboard');

    Route::get('/admin/dashboard', AdminDashboardController::class)
        ->middleware('ensureUserRole:admin')
        ->name('admin.dashboard');

    Route::get('/trainer/dashboard', PersonalTrainerDashboardController::class)
        ->middleware('ensureUserRole:trainer')
        ->name('trainer.dashboard');

    Route::get('/receptionist/dashboard', ReceptionistDashboardController::class)
        ->middleware('ensureUserRole:receptionist')
        ->name('receptionist.dashboard');

    Route::get('/pos/dashboard', PosDashboardController::class)
        ->middleware('ensureUserRole:admin,receptionist')
        ->name('pos.dashboard');

    Route::get('/scan-qr', ScanQrPageController::class)
        ->middleware('ensureUserRole:admin,receptionist')
        ->name('scan-qr.index');

    Route::get('/reports', ReportPageController::class)
        ->middleware('ensureUserRole:admin')
        ->name('reports.index');

    Route::prefix('member')->middleware('ensureUserRole:member')->group(function () {
        Route::get('bookings', [BookingController::class, 'index'])->name('member.booking.index');
        Route::post('booking', [BookingController::class, 'store'])->name('member.booking.store');
        Route::delete('booking/{booking}', [BookingController::class, 'destroy'])->name('member.booking.destroy');
    });

    Route::prefix('booking')->middleware('ensureUserRole:admin,trainer')->group(function () {
        Route::patch('{booking}/status', [BookingController::class, 'update'])->name('booking.update');
        Route::delete('{booking}', [BookingController::class, 'destroy'])->name('booking.destroy');
    });

    Route::post('/trainer/progress', [ProgressRecordController::class, 'store'])
        ->middleware('ensureUserRole:trainer')
        ->name('trainer.progress.store');
});