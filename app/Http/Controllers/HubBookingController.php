<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\MembershipPlan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class HubBookingController extends Controller
{
    public function index(): View
    {
        $this->authorizeRole('member');

        $trainers = User::where('role', 'trainer')->get();
        $myBookings = Booking::with('trainer')
            ->where('user_id', auth()->id())
            ->latest('booking_date')
            ->latest('booking_time')
            ->get();

        $hasActiveSub = Subscription::where('user_id', auth()->id())
            ->where('status', 'active')
            ->where('end_date', '>=', today())
            ->exists();

        $activeSub = Subscription::with('membershipPlan')
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->where('end_date', '>=', today())
            ->latest()
            ->first();

        $membershipPlans = MembershipPlan::where('is_active', true)->get();

        return view('hub.booking', compact('trainers', 'myBookings', 'hasActiveSub', 'activeSub', 'membershipPlans'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole('member');

        $validated = $request->validate([
            'trainer_id' => ['required', 'exists:users,id'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'booking_time' => ['required', 'date_format:H:i'],
            'session_type' => ['nullable', 'string', 'max:255'],
        ]);

        $trainer = User::where('id', $validated['trainer_id'])
            ->where('role', 'trainer')
            ->firstOrFail();

        $exists = Booking::where('trainer_id', $trainer->id)
            ->where('booking_date', $validated['booking_date'])
            ->where('booking_time', $validated['booking_time'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['booking_time' => 'Waktu tersebut sudah dibooking oleh trainer lain. Silakan pilih jadwal lain.'])->withInput();
        }

        $hasSubscription = \App\Models\Subscription::where('user_id', auth()->id())
            ->where('status', 'active')
            ->where('end_date', '>=', today())
            ->exists();

        Booking::create([
            'user_id' => auth()->id(),
            'trainer_id' => $trainer->id,
            'booking_date' => $validated['booking_date'],
            'booking_time' => $validated['booking_time'],
            'session_type' => $validated['session_type'] ?: 'Personal Training',
            'status' => 'pending',
            'is_direct' => !$hasSubscription,
            'admin_approved' => $hasSubscription,
        ]);

        if (!$hasSubscription) {
            $phone = '6281234567890';
            $text = urlencode("Halo Admin Siboti, saya " . auth()->user()->name . " ingin membooking PT " . $trainer->name . " pada tanggal " . $validated['booking_date'] . " jam " . $validated['booking_time'] . " secara direct (tanpa paket membership). Mohon konfirmasi pembayaran.");
            $waUrl = "https://wa.me/{$phone}?text={$text}";
            
            return back()->with('success', 'Data sudah dikirim ke admin. Mohon konfirmasi pembayaran.')
                         ->with('direct_wa_url', $waUrl)
                         ->with('wa_target', 'Admin');
        } else {
            $phone = '6289876543210';
            $text = urlencode("Halo PT " . $trainer->name . ", saya " . auth()->user()->name . " (Member Aktif) ingin membooking sesi latihan pada tanggal " . $validated['booking_date'] . " jam " . $validated['booking_time'] . ". Mohon konfirmasi jadwal.");
            $waUrl = "https://wa.me/{$phone}?text={$text}";

            return back()->with('success', 'Booking berhasil dibuat. Tunggu konfirmasi dari trainer.')
                         ->with('direct_wa_url', $waUrl)
                         ->with('wa_target', 'Trainer');
        }
    }

    public function destroy(Booking $booking)
    {
        $this->authorizeRole('member');

        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->status === 'completed') {
            return back()->withErrors(['booking' => 'Booking yang sudah selesai tidak dapat dibatalkan.']);
        }

        $booking->delete();

        return back()->with('success', 'Booking berhasil dibatalkan.');
    }
}
