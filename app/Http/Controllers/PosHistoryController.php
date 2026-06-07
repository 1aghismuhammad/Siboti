<?php

namespace App\Http\Controllers;

use App\Models\PosTransaction;
use Illuminate\View\View;

class PosHistoryController extends Controller
{
    public function __invoke(): View
    {
        $transactions = PosTransaction::latest('transacted_at')
            ->get()
            ->map(function (PosTransaction $transaction) {
                return [
                    'trxId' => $transaction->transaction_id,
                    'cashier' => $transaction->cashier,
                    'member' => $transaction->member_name ?? 'Non-Member',
                    'items_count' => $transaction->items_count,
                    'total' => 'Rp' . number_format($transaction->total, 0, ',', '.'),
                    'status' => $transaction->status,
                    'statusClass' => $transaction->status_class,
                    'time' => $transaction->transacted_at->format('d M Y, H:i'),
                ];
            })
            ->toArray();

        return view('pos.history', compact('transactions'));
    }
}
