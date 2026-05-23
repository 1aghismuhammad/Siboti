<?php

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