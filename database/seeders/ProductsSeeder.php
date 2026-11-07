<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'code' => 'REG',
                'name' => 'Cuci Reguler',
                'description' => 'Paket Cuci + Setrika 3 Hari',
                'price' => '4000',
                'duration' => 3,
            ],
            [
                'code' => 'INS',
                'name' => 'Cuci Instan',
                'description' => 'Paket Cuci + Setrika 1 Hari',
                'price' => '7000',
                'duration' => 1,
            ],
            [
                'code' => 'EXP',
                'name' => 'Cuci Express',
                'description' => 'Paket Cuci + Setrika Kilat 6 Jam',
                'price' => '10000',
                'duration' => 1,
            ],
        ];

        foreach ($products as $product) {
            Products::firstOrCreate(
                ['code' => $product['code']],
                $product
            );
        }
    }
}
