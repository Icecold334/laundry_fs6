<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'name' => 'Wildan A',
            'username' => 'wil',
            'email' => 'wakwaww234@gmail.com',
            'password' => Hash::make('pass')
        ]);
        User::factory(4)->create();
    }
}
