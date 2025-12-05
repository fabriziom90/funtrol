<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Supplier;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public function run(): void
    {
        $supplierIds = Supplier::pluck('id')->toArray();

        $products = [
            ['name' => 'Mozzarella', 'price' => 2.50, 'grams_in_warehouse' => 5000],
            ['name' => 'Pomodoro Pelato', 'price' => 1.20, 'grams_in_warehouse' => 8000],
            ['name' => 'Farina 00', 'price' => 0.90, 'grams_in_warehouse' => 10000],
            ['name' => 'Olio Extra Vergine', 'price' => 5.40, 'grams_in_warehouse' => 3000],
            ['name' => 'Basilico Fresco', 'price' => 1.00, 'grams_in_warehouse' => 500],
        ];

        foreach ($products as $product) {
            Product::create([
                ...$product,
                'supplier_id' => $supplierIds[array_rand($supplierIds)], // assegna random
            ]);
        }
    }
    
}
