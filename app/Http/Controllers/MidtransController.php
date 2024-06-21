<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Orders;
use App\Events\AlertEvent;
use App\Events\OrderEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // event(new AlertEvent(
        //     role: [1, 2],
        //     user_id: 0,
        //     time: Carbon::now()->diffForHumans(),
        //     alert: '<b>' . Auth::user()->name . '</b> berhasil melakukan pembayaran untuk pesanan <b>' . $order->code . '</b>!',
        //     color: 'secondary',
        //     icon: 'fa-solid fa-people-carry-box',
        //     link: '/orders/' . $order->code
        // ));
        return redirect()->route('orders.index')->with('success', 'Pembayaran berhasil!');
    }
    public function error()
    {
        return redirect()->route('orders.index')->with('error', 'Pembayaran gagal!');
    }
}
