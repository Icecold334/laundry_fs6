<?php

namespace Database\Seeders;

use App\Models\Orders;
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
            'phone' => '088888888888',
            'password' => Hash::make('admin')
        ]);
        User::factory()->create([
            'name' => 'Staff',
            'username' => 'staff',
            'role' => 2,
            'email' => 'staff@example.com',
            'phone' => '088888888888',
            'password' => Hash::make('staff')
        ]);
        User::factory()->create([
            'name' => 'User',
            'username' => 'user',
            'role' => 3,
            'email' => 'user@example.com',
            'phone' => '088888888888',
            'password' => Hash::make('user')
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
        Orders::factory()->create([
            'code' => 'INS000001',
            'product_id' => 2,
            'user_id' => 3,
            'quantity' => 3,
            'total' => 21000,
            'before' => 0,
            'after' => 0
        ]);
    }
}
