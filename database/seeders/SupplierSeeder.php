<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;
use App\Models\Store;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $stores = Store::all();

        foreach ($stores as $store) {
            for ($i = 1; $i <= 5; $i++) {
                Supplier::create([
                    'name' => "Fornitore $i - Store {$store->id}",
                    'email' => "fornitore$i-store{$store->id}@example.com",
                    'phone' => '33300000' . $i,
                    'store_id' => $store->id,
                ]);
            }
        }
    }
}
