<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {

    $user = auth()->user();

    switch ($user->role) {

        case 'admin':
            return redirect('/admin/dashboard');

        case 'trainer':
            return redirect('/trainer/dashboard');

        case 'receptionist':
            return redirect('/receptionist/dashboard');

        default:
            return redirect('/member/dashboard');
    }

})->middleware('auth')->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });

    // Admin - users management (basic index)
    Route::get('/admin/users', function () {
        $users = \App\Models\User::latest()->limit(50)->get();
        return view('admin.users.index', compact('users'));
    })->name('admin.users.index');

    Route::get('/member/dashboard', function () {
        return view('member.dashboard');
    });

    Route::get('/trainer/dashboard', function () {
        return view('trainer.dashboard');
    });

    Route::get('/receptionist/dashboard', function () {
        return view('receptionist.dashboard');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

require __DIR__.'/auth.php';