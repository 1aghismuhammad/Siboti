<?php

namespace App\Http\Controllers;

use App\Models\PosTransaction;
use App\Models\Product;
use App\Models\Subscription;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class PosDashboardController extends Controller
{
    public function __invoke(): View
    {
        $this->authorizeRole('receptionist');

        $todayTransactions = PosTransaction::whereDate('transacted_at', Carbon::today());
        $totalSales = $todayTransactions->sum('total');
        $soldProducts = $todayTransactions->sum('items_count');

        $stats = [
            [
                'label' => 'Transaksi Hari Ini',
                'value' => number_format($todayTransactions->count(), 0, ',', '.'),
                'note' => '+12% dari kemarin',
                'icon' => 'receipt_long',
                'variant' => 'positive',
            ],
            [
                'label' => 'Total Penjualan',
                'value' => 'Rp' . number_format($totalSales, 0, ',', '.'),
                'note' => '+8% dari target',
                'icon' => 'payments',
                'variant' => 'positive',
            ],
            [
                'label' => 'Produk Terjual',
                'value' => number_format($soldProducts, 0, ',', '.') . ' pcs',
                'note' => 'Stabil',
                'icon' => 'inventory_2',
                'variant' => 'neutral',
            ],
            [
                'label' => 'Produk Populer',
                'value' => Product::orderByDesc('sales_count')->first()?->name ?? 'Belum tersedia',
                'note' => sprintf('%s unit hari ini', number_format($todayTransactions->sum('items_count'), 0, ',', '.')),
                'icon' => 'trending_up',
                'variant' => 'positive',
            ],
        ];

        $products = Product::orderByDesc('sales_count')
            ->limit(6)
            ->get()
            ->map(function (Product $product) {
                return [
                    'id' => $product->code,
                    'name' => $product->name,
                    'category' => $product->category,
                    'description' => $product->description,
                    'price' => $product->price,
                    'priceText' => 'Rp' . number_format($product->price, 0, ',', '.'),
                    'stock' => $product->stock,
                    'badge' => $product->badge,
                    'badgeClass' => $product->badge_class,
                    'icon' => $product->icon,
                ];
            })
            ->toArray();

        $members = Subscription::with('user', 'membershipPlan')
            ->where('status', 'active')
            ->whereDate('end_date', '>=', Carbon::today())
            ->latest('end_date')
            ->limit(3)
            ->get()
            ->map(function ($subscription) {
                return [
                    'memberId' => sprintf('MEM-%04d', $subscription->user?->id ?? 0),
                    'name' => $subscription->user?->name ?? 'Guest',
                    'package' => $subscription->membershipPlan?->name ?? 'Membership',
                    'status' => 'Aktif',
                    'statusClass' => 'success',
                    'remaining' => Carbon::today()->diffInDays($subscription->end_date) . ' hari',
                    'initials' => $this->getInitials($subscription->user?->name ?? 'GM'),
                ];
            })
            ->toArray();

        $transactions = PosTransaction::latest('transacted_at')
            ->limit(3)
            ->get()
            ->map(function (PosTransaction $transaction) {
                return [
                    'trxId' => $transaction->transaction_id,
                    'cashier' => $transaction->cashier,
                    'member' => $transaction->member_name ?? 'Non-Member',
                    'total' => 'Rp' . number_format($transaction->total, 0, ',', '.'),
                    'status' => $transaction->status,
                    'statusClass' => $transaction->status_class,
                    'time' => $transaction->transacted_at->format('H:i'),
                ];
            })
            ->toArray();

        $topProducts = Product::orderByDesc('sales_count')
            ->limit(3)
            ->get()
            ->map(function (Product $product, $index) {
                return [
                    'rank' => $index + 1,
                    'name' => $product->name,
                    'sold' => number_format($product->sales_count, 0, ',', '.') . ' pcs',
                ];
            })
            ->toArray();

        $trendingProducts = Product::orderByDesc('sales_count')
            ->limit(2)
            ->get()
            ->map(function (Product $product) {
                return [
                    'name' => $product->name,
                    'growth' => '+25%',
                    'note' => 'Naik sejak promo minggu ini',
                ];
            })
            ->toArray();

        $activities = PosTransaction::latest('transacted_at')
            ->limit(4)
            ->get()
            ->map(function (PosTransaction $transaction) {
                return [
                    'icon' => 'point_of_sale',
                    'text' => sprintf('Transaksi %s oleh %s berhasil disimpan.', $transaction->transaction_id, $transaction->cashier),
                    'time' => $transaction->transacted_at->diffForHumans(),
                ];
            })
            ->toArray();

        $alerts = [
            [
                'title' => 'Stok Produk Rendah',
                'description' => Product::where('stock', '<=', 5)->count() . ' produk perlu restok segera.',
                'type' => 'danger',
                'icon' => 'warning',
            ],
            [
                'title' => 'Transaksi Pending',
                'description' => PosTransaction::where('status', 'Pending')->count() . ' transaksi belum selesai.',
                'type' => 'warning',
                'icon' => 'pending_actions',
            ],
        ];

        return view('pos.dashboard', compact(
            'stats',
            'products',
            'members',
            'transactions',
            'topProducts',
            'trendingProducts',
            'activities',
            'alerts'
        ));
    }

    private function getInitials(string $name): string
    {
        return collect(explode(' ', $name))->map(fn ($part) => strtoupper(substr($part, 0, 1)))->join('');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $this->authorizeRole('receptionist');

        $request->validate([
            'total' => 'required|numeric|min:0',
            'items_count' => 'required|integer|min:1',
            'cart' => 'required|array',
        ]);

        $transaction = PosTransaction::create([
            'transaction_id' => 'TRX-' . strtoupper(uniqid()),
            'cashier' => auth()->user()->name ?? 'Receptionist',
            'user_id' => null,
            'member_name' => 'Guest', // Since the frontend doesn't select a member yet
            'total' => $request->total,
            'items_count' => $request->items_count,
            'status' => 'Paid',
            'status_class' => 'success',
            'transacted_at' => Carbon::now(),
        ]);

        foreach ($request->cart as $code => $qty) {
            $product = Product::where('code', $code)->first();
            if ($product) {
                $product->decrement('stock', $qty);
                $product->increment('sales_count', $qty);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil disimpan',
            'transaction' => $transaction
        ]);
    }

    public function storeProduct(\Illuminate\Http\Request $request)
    {
        $this->authorizeRole('receptionist');

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $code = 'PRD-' . strtoupper(substr(uniqid(), -5));

        Product::create([
            'code' => $code,
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'badge' => 'Baru',
            'badge_class' => 'success',
            'icon' => 'inventory_2',
            'sales_count' => 0,
        ]);

        return redirect()->route('pos.dashboard')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function destroyProduct($id)
    {
        $this->authorizeRole('receptionist');

        $product = Product::where('code', $id)->firstOrFail();
        $product->delete();

        return redirect()->route('pos.dashboard')->with('success', 'Produk berhasil dihapus.');
    }
}
