<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin
        User::firstOrCreate(
            ['email' => 'adminadmin@gmail.com'],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'role' => 1,
                'phone' => '088888888888',
                'password' => Hash::make('admin'),
                'status' => 1,
                'email_verified_at' => now(),
            ]
        );

        // 2. Akun Staff / Karyawan
        User::firstOrCreate(
            ['email' => 'staff@example.com'],
            [
                'name' => 'Staff',
                'username' => 'staff',
                'role' => 2,
                'phone' => '087777777777',
                'password' => Hash::make('staff'),
                'status' => 1,
                'email_verified_at' => now(),
            ]
        );

        // 3. Panggil Seeders (Produk, Pelanggan, dan Transaksi Laundry)
        $this->call([
            ProductsSeeder::class,
            CustomerSeeder::class,
            OrdersSeeder::class,
        ]);
    }
}
