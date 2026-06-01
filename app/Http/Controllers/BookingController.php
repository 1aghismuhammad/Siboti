<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        $bookings = auth()->user()->bookings()->latest()->get();

        return view('member.bookings', compact('bookings'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'booking_time' => ['required', 'regex:/^\d{2}\.\d{2}(?:\s*-\s*\d{2}\.\d{2})?$/' ],
            'session_type' => ['nullable', 'string', 'max:100'],
        ]);

        $timeParts = preg_split('/\s*-\s*/', $request->booking_time);
        $time = collect($timeParts)
            ->map(fn ($part) => str_replace('.', ':', $part) . ':00')
            ->implode(' - ');

        Booking::create([
            'user_id' => auth()->id(),
            'booking_date' => $request->booking_date,
            'booking_time' => $time,
            'session_type' => $request->session_type ?: 'Sesi Gym',
            'status' => 'pending',
        ]);

        return redirect()->route('member.booking.index')
            ->with('success', 'Booking berhasil disimpan. Silakan tunggu konfirmasi.');
    }

    public function update(Request $request, Booking $booking): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:pending,approved,cancelled,completed'],
        ]);

        if (! auth()->user()->hasAnyRole(['admin', 'trainer'])) {
            abort(403, 'Unauthorized action.');
        }

        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Status booking telah diubah.');
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        $user = auth()->user();

        if ($user->hasRole('member') && $booking->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        if (! $user->hasAnyRole(['admin', 'trainer']) && ! $user->hasRole('member')) {
            abort(403, 'Unauthorized action.');
        }

        $booking->delete();

        return back()->with('success', 'Booking berhasil dibatalkan.');
    }
}
