<?php

namespace App\Http\Controllers;

use App\Models\MembershipPlan;
use App\Models\Subscription;
use Illuminate\Http\Request;

class HubMembershipController extends Controller
{
    public function buy($plan_id)
    {
        $this->authorizeRole('member');

        $plan = MembershipPlan::findOrFail($plan_id);

        // Cancel previous pending subscriptions
        Subscription::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->update(['status' => 'cancelled']);

        Subscription::create([
            'user_id' => auth()->id(),
            'membership_plan_id' => $plan->id,
            'start_date' => now(),
            'end_date' => now()->addMonths($plan->duration_months ?? 1),
            'status' => 'pending',
        ]);

        $phone = '6281234567890';
        $text = urlencode("Halo Admin Siboti, saya " . auth()->user()->name . " ingin mengaktifkan Membership Paket " . $plan->name . ". Mohon konfirmasi pembayaran saya.");
        
        return redirect("https://wa.me/{$phone}?text={$text}");
    }
}
