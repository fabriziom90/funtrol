<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Store;
use App\Models\Supplier;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public function run(): void
    {
        $stores = Store::all();
        $units = ['g', 'kg', 'pz', 'ml'];

        

        foreach ($stores as $store) {

            $suppliers = Supplier::where('store_id', $store->id)->get();

            if ($suppliers->isEmpty()) {
                $this->command->info("Lo store {$store->id} non ha fornitori.");
                continue;
            }

            for ($i = 1; $i <= 50; $i++) {

                $supplier = $suppliers->random();
                $unit = $units[array_rand($units)];

                // Se l’unità è kg, convertiamo tutto in grammi
                if ($unit === 'kg') {
                    $stock = rand(5, 100) * 1000;      // 5kg - 100kg
                    $minStock = rand(1, 10) * 1000;    // 1kg - 10kg
                } else {
                    $stock = rand(500, 20000);         // 0.5kg - 20kg
                    $minStock = rand(200, 5000);       // soglia
                }

                Product::create([
                    'name' => "Prodotto $i - Store {$store->id}",
                    'price' => rand(100, 2000) / 100,
                    'unit' => $units[array_rand($units)],
                    'store_id' => $store->id,
                    'supplier_id' => $supplier->id,
                    'grams_in_warehouse' => $stock,
                    'min_stock' => $minStock,
                ]);
            }
        }
    }
}
