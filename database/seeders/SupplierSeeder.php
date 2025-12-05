<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['name' => 'Fornitore Mario', 'email' => 'mario@example.com', 'phone' => '3331112222'],
            ['name' => 'Fresh Foods Srl', 'email' => 'info@freshfoods.com', 'phone' => '3332223333'],
            ['name' => 'Quality Ingredients Spa', 'email' => 'contatti@qi.com', 'phone' => '3334445555'],
            ['name' => 'Bio Prime', 'email' => 'bio.prime@example.com', 'phone' => '3201234567'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
