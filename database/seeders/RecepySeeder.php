<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Recepy;

class RecepySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->info('Non ci sono prodotti! Popola prima i prodotti.');
            return;
        }

        // Creiamo 10 ricette di esempio
        for ($i = 1; $i <= 10; $i++) {
            $recepy = Recepy::create([
                'name' => "Ricetta $i",
                'description' => "Descrizione della ricetta $i",
                'price' => rand(5, 50), // prezzo casuale
            ]);

            // Associa ingredienti casuali (3-5 prodotti per ricetta)
            $ingredientProducts = $products->random(rand(3, 5));

            $pivotData = [];
            foreach ($ingredientProducts as $product) {
                $pivotData[$product->id] = [
                    'grams_used' => rand(50, 500), // quantità casuale
                ];
            }

            $recepy->products()->sync($pivotData);
        }
    }
}
