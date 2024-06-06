<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    // index
    public function index(Request $request)
    {
        // Set your Merchant Server Key
        Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = false;
        // Set sanitization on (default)
        Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        Config::$is3ds = true;
        $params = [
            'transaction_details' => [
                'order_id' => rand(),
                'gross_amount' => $request->total,
            ],
            'item_details' => [json_decode($request->item_details, true)],
            'customer_details' => [
                'first_name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ],
        ];

        return Snap::getSnapToken($params);
    }
    // payment success
    public function success(Request $request, Orders $orders)
    {
        $order = $orders->all()->find($request->id);
        $order->status = 2;
        $order->update();
        return redirect()->route('orders.index')->with('success', 'Pembayaran Berhasil!');
    }
    public function error()
    {
        return redirect()->route('orders.index')->with('error', 'Pembayaran Gagal!');
    }
}
