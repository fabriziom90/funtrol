<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Store;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $superadmin = User::create([
        //     'name' => 'Oda Visual Studio',
        //     'email' => 'info@odavisualstudio.it',
        //     'password' => Hash::make('FunTr0l2025!!'),
        //     'role'  => 'superadmin'
        // ]);

        // OWNER PER OGNI STORE
        $stores = Store::all();

        foreach ($stores as $store) {
            User::create([
                'name' => $store->owner_name,
                'email' => strtolower(str_replace(' ', '', $store->owner_name)) . '@funtrol.com',
                'password' => Hash::make('password'),
                'role' => 'owner',
                'store_id' => $store->id,
            ]);
        }
        
    }
}
