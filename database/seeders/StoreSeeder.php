<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Store;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Store::create([
            'name' => 'Negozio Roma',
            'owner_name' => 'Mario Rossi',
            'email' => 'roma@example.com',
        ]);

        Store::create([
            'name' => 'Negozio Milano',
            'owner_name' => 'Luca Bianchi',
            'email' => 'milano@example.com',
        ]);

        Store::create([
            'name' => 'Negozio Torino',
            'owner_name' => 'Gianni Verdi',
            'email' => 'torino@example.com',
        ]);

        Store::create([
            'name' => 'Negozio Napoli',
            'owner_name' => 'Luca Gialli',
            'email' => 'napoli@example.com',
        ]);

        Store::create([
            'name' => 'Negozio Bari',
            'owner_name' => 'Marco Neri',
            'email' => 'bari@example.com',
        ]);
    }
}
