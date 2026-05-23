<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ReceptionistDashboardController;

Route::get('/', function () {
    return view('home');
});

Route::redirect('/admin', '/admin/dashboard');
Route::get('/admin/dashboard', AdminDashboardController::class)->name('admin.dashboard');

Route::redirect('/receptionist', '/receptionist/dashboard');
Route::get('/receptionist/dashboard', ReceptionistDashboardController::class)->name('receptionist.dashboard');
