<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PosDashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            [
                'label' => 'Transaksi Hari Ini',
                'value' => '24',
                'note' => '+12% dari kemarin',
                'icon' => 'receipt_long',
                'variant' => 'positive',
            ],
            [
                'label' => 'Total Penjualan',
                'value' => 'Rp4,25 jt',
                'note' => '+8% dari target',
                'icon' => 'payments',
                'variant' => 'positive',
            ],
            [
                'label' => 'Produk Terjual',
                'value' => '156 pcs',
                'note' => 'Stabil',
                'icon' => 'inventory_2',
                'variant' => 'neutral',
            ],
            [
                'label' => 'Produk Populer',
                'value' => 'Whey Isolate',
                'note' => '12 unit hari ini',
                'icon' => 'trending_up',
                'variant' => 'positive',
            ],
        ];

        $products = [
            [
                'id' => 'P-001',
                'name' => 'Air Mineral 600ml',
                'category' => 'Minuman',
                'description' => 'Hidrasi esensial untuk member setelah latihan.',
                'price' => 5000,
                'priceText' => 'Rp5.000',
                'stock' => 5,
                'badge' => 'Stok Rendah',
                'badgeClass' => 'danger',
                'icon' => 'water_bottle',
            ],
            [
                'id' => 'P-002',
                'name' => 'Protein Shake Vanilla',
                'category' => 'Supplement',
                'description' => 'Minuman protein siap konsumsi, 25g protein per serving.',
                'price' => 35000,
                'priceText' => 'Rp35.000',
                'stock' => 28,
                'badge' => 'Laris',
                'badgeClass' => 'success',
                'icon' => 'local_cafe',
            ],
            [
                'id' => 'P-003',
                'name' => 'SiBoti Microfiber Towel',
                'category' => 'Aksesoris',
                'description' => 'Handuk gym quick dry dengan branding SiBoti.',
                'price' => 85000,
                'priceText' => 'Rp85.000',
                'stock' => 14,
                'badge' => 'Ready',
                'badgeClass' => 'neutral',
                'icon' => 'dry_cleaning',
            ],
            [
                'id' => 'P-004',
                'name' => 'Whey Protein 1kg',
                'category' => 'Supplement',
                'description' => 'Produk suplemen protein utama untuk kebutuhan recovery.',
                'price' => 850000,
                'priceText' => 'Rp850.000',
                'stock' => 11,
                'badge' => 'Best Seller',
                'badgeClass' => 'success',
                'icon' => 'nutrition',
            ],
            [
                'id' => 'P-005',
                'name' => 'Shaker Pro Series',
                'category' => 'Aksesoris',
                'description' => 'Shaker botol premium untuk protein dan pre-workout.',
                'price' => 120000,
                'priceText' => 'Rp120.000',
                'stock' => 20,
                'badge' => 'Ready',
                'badgeClass' => 'neutral',
                'icon' => 'sports_mma',
            ],
            [
                'id' => 'P-006',
                'name' => 'SiBoti Training Shirt',
                'category' => 'Merchandise',
                'description' => 'Kaos latihan dry-fit dengan desain resmi SiBoti.',
                'price' => 150000,
                'priceText' => 'Rp150.000',
                'stock' => 9,
                'badge' => 'Limited',
                'badgeClass' => 'warning',
                'icon' => 'checkroom',
            ],
        ];

        $initialCart = [
            ['productId' => 'P-002', 'qty' => 1],
            ['productId' => 'P-003', 'qty' => 1],
        ];

        $members = [
            [
                'memberId' => 'MEM-0012',
                'name' => 'Budi Santoso',
                'package' => 'Gold Annual',
                'status' => 'Aktif',
                'statusClass' => 'success',
                'remaining' => '148 hari',
                'initials' => 'BS',
            ],
            [
                'memberId' => 'MEM-0455',
                'name' => 'Santi Rahayu',
                'package' => 'Silver Monthly',
                'status' => 'Expired',
                'statusClass' => 'danger',
                'remaining' => '0 hari',
                'initials' => 'SR',
            ],
            [
                'memberId' => 'MEM-0891',
                'name' => 'Adrian Pratama',
                'package' => 'Monthly Elite',
                'status' => 'Aktif',
                'statusClass' => 'success',
                'remaining' => '24 hari',
                'initials' => 'AP',
            ],
        ];

        $transactions = [
            [
                'trxId' => '#TRX-9821',
                'cashier' => 'Receptionist Andi',
                'member' => 'Budi Santoso',
                'total' => 'Rp125.000',
                'status' => 'Berhasil',
                'statusClass' => 'success',
                'time' => '10.45',
            ],
            [
                'trxId' => '#TRX-9820',
                'cashier' => 'Receptionist Andi',
                'member' => 'Non-Member',
                'total' => 'Rp5.000',
                'status' => 'Berhasil',
                'statusClass' => 'success',
                'time' => '10.30',
            ],
            [
                'trxId' => '#TRX-9819',
                'cashier' => 'Admin Siska',
                'member' => 'Dewi Lestari',
                'total' => 'Rp450.000',
                'status' => 'Pending',
                'statusClass' => 'warning',
                'time' => '09.15',
            ],
        ];

        $topProducts = [
            ['rank' => 1, 'name' => 'Whey Protein 1kg', 'sold' => '45 pcs'],
            ['rank' => 2, 'name' => 'Creatine Monohydrate', 'sold' => '32 pcs'],
            ['rank' => 3, 'name' => 'Shaker Pro Series', 'sold' => '28 pcs'],
        ];

        $trendingProducts = [
            ['name' => 'Pre-Workout Neon', 'growth' => '+25%', 'note' => 'Naik sejak promo minggu ini'],
            ['name' => 'BCAA Recovery', 'growth' => '+18%', 'note' => 'Populer di kelas pagi'],
        ];

        $activities = [
            ['icon' => 'inventory_2', 'text' => 'Restok inventaris dilakukan oleh Admin Siska.', 'time' => '15 menit yang lalu'],
            ['icon' => 'point_of_sale', 'text' => 'Transaksi Protein Shake Vanilla berhasil disimpan.', 'time' => '31 menit yang lalu'],
            ['icon' => 'sell', 'text' => 'Harga Member Premium Kit diperbarui sistem.', 'time' => '1 jam yang lalu'],
            ['icon' => 'cancel', 'text' => 'Transaksi #TRX-9700 dibatalkan oleh kasir.', 'time' => '2 jam yang lalu'],
        ];

        $alerts = [
            [
                'title' => 'Stok Air Mineral Rendah',
                'description' => 'Sisa 5 botol. Prioritaskan restok sebelum jam ramai sore.',
                'type' => 'danger',
                'icon' => 'warning',
            ],
            [
                'title' => 'Transaksi Pending',
                'description' => 'Terdapat 3 transaksi pending yang perlu diselesaikan atau dibatalkan.',
                'type' => 'warning',
                'icon' => 'pending_actions',
            ],
        ];

        return view('pos.dashboard', compact(
            'stats',
            'products',
            'initialCart',
            'members',
            'transactions',
            'topProducts',
            'trendingProducts',
            'activities',
            'alerts'
        ));
    }
}
