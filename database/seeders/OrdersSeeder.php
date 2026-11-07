<?php

namespace Database\Seeders;

use App\Models\Orders;
use App\Models\Products;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // -------------------------------------------------------------
        // Jumlah transaksi yang ingin dibuat (bisa diubah sesuka hati)
        // -------------------------------------------------------------
        $totalOrders = 100;

        // 1. Pastikan produk/layanan laundry tersedia
        if (Products::count() === 0) {
            $this->call(ProductsSeeder::class);
        }
        $products = Products::all();

        // 2. Pastikan 5 pelanggan tersedia
        $customerEmails = [
            'budi@gmail.com',
            'siti@gmail.com',
            'ahmad@gmail.com',
            'dewi@gmail.com',
            'rian@gmail.com',
        ];

        $customers = User::whereIn('email', $customerEmails)->get();
        if ($customers->count() < 5) {
            $this->call(CustomerSeeder::class);
            $customers = User::whereIn('email', $customerEmails)->get();
        }

        // 3. Pastikan staf/admin penanggung jawab tersedia
        $staff = User::whereIn('role', [1])->first();
        if (!$staff) {
            $staff = User::firstOrCreate(
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
        }

        // Inisialisasi nomor urut kode pesanan per produk agar performa cepat
        $productCounters = [];
        foreach ($products as $product) {
            $existingCodes = Orders::withTrashed()
                ->where('code', 'like', $product->code . '%')
                ->pluck('code');

            $maxNumber = 0;
            foreach ($existingCodes as $code) {
                $numPart = (int) substr($code, strlen($product->code));
                if ($numPart > $maxNumber) {
                    $maxNumber = $numPart;
                }
            }
            $productCounters[$product->code] = $maxNumber;
        }

        // 4. Looping langsung sejumlah $totalOrders (misal 100 transaksi)
        // Status pesanan:
        // 0 = Pesanan Dibuat
        // 1 = Menunggu Pembayaran
        // 2 = Pesanan Diproses
        // 3 = Pesanan Siap Diambil
        // 4 = Pesanan Selesai
        for ($i = 0; $i < $totalOrders; $i++) {
            // Pilih pelanggan secara acak dari 5 pelanggan
            $customer = $customers->random();

            // Pilih produk secara acak
            $product = $products->random();

            // Status acak antara 0 sampai 4
            $status = rand(0, 4);

            $method = rand(0, 1); // 0 = Tunai, 1 = Non-Tunai
            $before = $method === 0 ? 0 : rand(0, 1); // 0 = Diantar, 1 = Diambil
            $after = rand(0, 1); // 0 = Diambil, 1 = Diantar

            // Menggunakan Faker untuk alamat
            $address = fake('id_ID')->address();

            // Pengaturan jumlah, total biaya, dan staf penanggung jawab
            $quantity = null;
            $total = null;
            $assignedStaff = null;
            $review = null;

            if ($status >= 1) {
                $quantity = rand(1, 10);
                $total = $quantity * (int) $product->price;
                $assignedStaff = $staff->id;
            }

            // Jika pesanan selesai (status 4), isi ulasan menggunakan Faker
            if ($status === 4) {
                $review = fake('id_ID')->sentence(15);
            }

            // Generate nomor urut kode pesanan (contoh: REG000001, INS000002)
            $productCounters[$product->code]++;
            $orderCode = $product->code . sprintf('%06d', $productCounters[$product->code]);

            // Waktu transaksi dibuat (acak dalam 30 hari terakhir agar dashboard & laporan terisi bagus)
            $daysAgo = rand(0, 30);
            $hoursAgo = rand(1, 23);
            $minutesAgo = rand(1, 59);
            $createdAt = Carbon::now()->subDays($daysAgo)->subHours($hoursAgo)->subMinutes($minutesAgo);
            $updatedAt = $createdAt->copy()->addHours(rand(1, 4));

            $order = new Orders();
            $order->code = $orderCode;
            $order->user_id = $customer->id;
            $order->staff_id = $assignedStaff;
            $order->product_id = $product->id;
            $order->quantity = $quantity;
            $order->before = $before;
            $order->after = $after;
            $order->method = $method;
            $order->address = $address;
            $order->status = $status;
            $order->total = $total;
            $order->review = $review;
            $order->created_at = $createdAt;
            $order->updated_at = $updatedAt;
            $order->save();
        }
    }
}
