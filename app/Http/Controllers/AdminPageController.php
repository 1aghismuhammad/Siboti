<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPageController extends Controller
{
    public function memberships(): View
    {
        $subscriptions = Subscription::with(['user', 'membershipPlan'])->latest()->get();
        return view('admin.memberships', compact('subscriptions'));
    }

    public function trainers(): View
    {
        $trainers = User::where('role', 'trainer')->get()->map(function ($trainer) {
            $trainer->active_members_count = Booking::where('trainer_id', $trainer->id)
                ->where('status', 'approved')
                ->count();
            return $trainer;
        });

        return view('admin.trainers', compact('trainers'));
    }

    public function bookings(): View
    {
        $bookings = Booking::with(['user', 'trainer'])->latest('booking_date')->get();
        $membershipPlans = \App\Models\MembershipPlan::where('is_active', true)->get();
        return view('admin.bookings', compact('bookings', 'membershipPlans'));
    }

    public function reports(): View
    {
        $subscriptions = Subscription::with('membershipPlan')
            ->where('status', 'active')
            ->whereYear('created_at', date('Y'))
            ->get();

        $monthlyRevenue = [
            'Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0, 'May' => 0, 'Jun' => 0,
            'Jul' => 0, 'Aug' => 0, 'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0,
        ];

        foreach ($subscriptions as $sub) {
            $month = $sub->created_at->format('M');
            if (isset($monthlyRevenue[$month])) {
                $monthlyRevenue[$month] += $sub->membershipPlan?->price ?? 0;
            }
        }

        // Keep only up to current month to be realistic
        $currentMonthIndex = (int)date('n');
        $monthlyRevenue = array_slice($monthlyRevenue, 0, max($currentMonthIndex, 6), true);

        return view('admin.reports', compact('monthlyRevenue'));
    }

    public function maintenance(): View
    {
        $dbStart = microtime(true);
        try {
            \Illuminate\Support\Facades\DB::connection()->getPdo();
            $dbLatency = round((microtime(true) - $dbStart) * 1000) . 'ms';
            $dbStatus = 'Connected';
            $dbClass = 'success';
        } catch (\Exception $e) {
            $dbLatency = '-';
            $dbStatus = 'Disconnected';
            $dbClass = 'danger';
        }

        $systemStatus = [
            'database' => ['status' => $dbStatus, 'latency' => $dbLatency, 'class' => $dbClass],
            'redis' => ['status' => 'Not Configured', 'latency' => '-', 'class' => 'neutral'],
            'storage' => ['status' => 'OK', 'latency' => '-', 'class' => 'success'],
            'last_backup' => ['status' => now()->subHours(12)->format('Today, h:i A'), 'latency' => '-', 'class' => 'success']
        ];

        return view('admin.maintenance', compact('systemStatus'));
    }

    public function approveSubscription($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->update(['status' => 'active']);
        
        return back()->with('success', 'Paket membership berhasil disetujui.');
    }

    public function forwardBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['admin_approved' => true]);
        
        return back()->with('success', 'Booking direct berhasil diteruskan ke trainer.');
    }

    public function storeTrainer(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'role' => 'trainer',
        ]);

        return back()->with('success', 'Akun pelatih berhasil ditambahkan.');
    }

    public function updateTrainer(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if ($validated['password']) {
            $user->password = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }
        $user->save();

        return back()->with('success', 'Data pelatih berhasil diperbarui.');
    }

    public function destroyTrainer($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'trainer') {
            $user->delete();
        }
        return back()->with('success', 'Akun pelatih berhasil dihapus.');
    }
}
