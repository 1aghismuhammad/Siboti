<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'code' => 'PRD-001',
                'name' => 'Air Mineral 600ml',
                'category' => 'Minuman',
                'description' => 'Air mineral segar botol 600ml',
                'price' => 5000,
                'stock' => 100,
                'badge' => 'Terlaris',
                'badge_class' => 'positive',
                'icon' => 'water_drop',
                'sales_count' => 120,
            ],
            [
                'code' => 'PRD-002',
                'name' => 'Whey Protein Isolate',
                'category' => 'Suplemen',
                'description' => 'Satu scoop protein isolate (30g protein)',
                'price' => 25000,
                'stock' => 50,
                'badge' => 'Promo',
                'badge_class' => 'warning',
                'icon' => 'science',
                'sales_count' => 85,
            ],
            [
                'code' => 'PRD-003',
                'name' => 'Protein Bar Coklat',
                'category' => 'Makanan',
                'description' => 'Snack sehat tinggi protein rasa coklat',
                'price' => 20000,
                'stock' => 75,
                'badge' => null,
                'badge_class' => 'neutral',
                'icon' => 'lunch_dining',
                'sales_count' => 45,
            ],
            [
                'code' => 'PRD-004',
                'name' => 'Isotonic Drink 500ml',
                'category' => 'Minuman',
                'description' => 'Minuman isotonik pengembali ion tubuh',
                'price' => 8000,
                'stock' => 120,
                'badge' => null,
                'badge_class' => 'neutral',
                'icon' => 'sports_bar',
                'sales_count' => 95,
            ],
            [
                'code' => 'PRD-005',
                'name' => 'Pre-Workout Drink',
                'category' => 'Suplemen',
                'description' => 'Minuman energi sebelum latihan',
                'price' => 22000,
                'stock' => 40,
                'badge' => 'Baru',
                'badge_class' => 'success',
                'icon' => 'bolt',
                'sales_count' => 15,
            ],
            [
                'code' => 'PRD-006',
                'name' => 'Dada Ayam Rebus (150g)',
                'category' => 'Makanan',
                'description' => 'Dada ayam rebus siap makan',
                'price' => 25000,
                'stock' => 20,
                'badge' => null,
                'badge_class' => 'neutral',
                'icon' => 'set_meal',
                'sales_count' => 60,
            ],
            [
                'code' => 'PRD-007',
                'name' => 'Pisang Cavendish',
                'category' => 'Makanan',
                'description' => 'Buah pisang segar penambah energi',
                'price' => 4000,
                'stock' => 60,
                'badge' => null,
                'badge_class' => 'neutral',
                'icon' => 'bakery_dining',
                'sales_count' => 110,
            ]
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['code' => $product['code']],
                $product
            );
        }
    }
}
