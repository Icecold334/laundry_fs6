<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Budi Santoso',
                'username' => 'budi',
                'email' => 'budi@gmail.com',
                'phone' => '081234567801',
                'password' => Hash::make('password'),
                'role' => 3,
                'status' => 1,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Siti Aminah',
                'username' => 'siti',
                'email' => 'siti@gmail.com',
                'phone' => '081234567802',
                'password' => Hash::make('password'),
                'role' => 3,
                'status' => 1,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Ahmad Fauzi',
                'username' => 'ahmad',
                'email' => 'ahmad@gmail.com',
                'phone' => '081234567803',
                'password' => Hash::make('password'),
                'role' => 3,
                'status' => 1,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Dewi Lestari',
                'username' => 'dewi',
                'email' => 'dewi@gmail.com',
                'phone' => '081234567804',
                'password' => Hash::make('password'),
                'role' => 3,
                'status' => 1,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Rian Pratama',
                'username' => 'rian',
                'email' => 'rian@gmail.com',
                'phone' => '081234567805',
                'password' => Hash::make('password'),
                'role' => 3,
                'status' => 1,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($customers as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                $data
            );
        }
    }
}

