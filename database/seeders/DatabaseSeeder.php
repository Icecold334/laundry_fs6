<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Products;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'role' => 1,
            'email' => 'adminadmin@gmail.com',
            'password' => Hash::make('admin')
        ]);
        User::factory()->create([
            'name' => 'Fauzan',
            'username' => 'fauzan',
            'role' => 3,
            'email' => 'fauzanimam334@gmail.com',
            'password' => Hash::make('fau')
        ]);
        Products::factory()->create([
            'name' => 'Reguler',
            'price' => 4000,
            'duration' => 3,
            'code' => 'REG',
            'description' => 'Paket Cuci + Setrika 3 Hari'
        ]);
        Products::factory()->create([
            'name' => 'Instan',
            'price' => 7000,
            'duration' => 1,
            'code' => 'INS',
            'description' => 'Paket Cuci + Setrika 1 Hari'
        ]);
    }
}
