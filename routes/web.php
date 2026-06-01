<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PersonalTrainerDashboardController;
use App\Http\Controllers\PosDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReceptionistDashboardController;
use App\Http\Controllers\ReportPageController;
use App\Http\Controllers\ScanQrPageController;
use App\Http\Middleware\EnsureUserRole;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Auth
Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

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

// Trainer Panel
Route::get('/trainer/login', function () {
    return view('crud_pelatih.login');
});

Route::get('/trainer/register', function () {
    return view('crud_pelatih.register');
});

Route::get('/trainer/dashboard', function () {
    return view('crud_pelatih.dashboard');
});

Route::get('/hub/booking', function () {
    return view('hub.booking');
});