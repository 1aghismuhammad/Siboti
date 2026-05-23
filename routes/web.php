<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ReceptionistDashboardController;
use App\Http\Controllers\PersonalTrainerDashboardController;
use App\Http\Controllers\PosDashboardController;

Route::get('/', function () {
    return view('home');
});

Route::redirect('/admin', '/admin/dashboard');
Route::get('/admin/dashboard', AdminDashboardController::class)->name('admin.dashboard');

Route::redirect('/receptionist', '/receptionist/dashboard');
Route::get('/receptionist/dashboard', ReceptionistDashboardController::class)->name('receptionist.dashboard');

Route::redirect('/trainer', '/trainer/dashboard');
Route::get('/trainer/dashboard', PersonalTrainerDashboardController::class)->name('trainer.dashboard');

Route::redirect('/pos', '/pos/dashboard');
Route::get('/pos/dashboard', PosDashboardController::class)->name('pos.dashboard');
