<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
    // Cek apakah request datang dari route trainer
        if ($request->is('trainer/*')) {
            return view('crud_trainer.login');
        }

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        if ($request->is('trainer/*') && $user->role !== 'trainer') {
            Auth::logout();
            return back()->withErrors(['email' => 'Akun ini tidak memiliki akses Trainer. Gunakan halaman login utama atau akun trainer.']);
        }

        switch ($user->role) {

            case 'admin':
                return redirect('/admin/dashboard');

            case 'trainer':
                return redirect('/trainer/dashboard');

            case 'receptionist':
                return redirect('/receptionist/dashboard');

            default:
                // Members should be sent to the public hub section
                return redirect('/hub/dashboard');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}