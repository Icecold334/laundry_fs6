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
            'name' => 'Fauzan Imam',
            'username' => 'fauzan',
            'email' => 'fauzanimam334@gmail.com',
            'password' => Hash::make('password')
        ]);
        User::factory(4)->create();
    }
}
