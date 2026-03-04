<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Recepy;
use App\Models\Store;

class RecepySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = Store::all();

        $units = ['pz', 'kg'];

        foreach ($stores as $store) {
            for ($i = 1; $i <= 20; $i++) {

                $recipe = Recepy::create([
                    'name' => "Ricetta $i - Store {$store->id}",
                    'unit' => $units[array_rand($units)],
                    'description' => "Descrizione della ricetta $i per lo store {$store->id}",
                    'store_id' => $store->id,
                ]);

                // Associa ingredienti
                $products = Product::where('store_id', $store->id)
                    ->inRandomOrder()
                    ->take(rand(3, 5))
                    ->get();

                $pivotData = [];

                foreach ($products as $product) {
                    $pivotData[$product->id] = [
                        'grams_used' => rand(50, 500),
                    ];
                }

                $recipe->products()->sync($pivotData);
            }
        }
    }
}
