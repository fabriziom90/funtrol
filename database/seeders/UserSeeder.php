<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = User::create([
            'name' => 'Oda Visual Studio',
            'email' => 'info@odavisualstudio.it',
            'password' => Hash::make('FunTr0l2025!!'),
            'role'  => 'admin'
        ]);
        
    }
}
