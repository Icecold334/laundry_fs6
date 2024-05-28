<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    // index
    public function index(Request $request)
    {
        // Set your Merchant Server Key
        Config::$serverKey = 'SB-Mid-server-JsXksTptF6jmCXbqraGCN9Q5';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = false;
        // Set sanitization on (default)
        Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        Config::$is3ds = true;
        // Fungsi untuk mendapatkan Snap Token dengan menonaktifkan verifikasi sertifikat SSL
        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $request->total,
            ),
            'customer_details' => array(
                'first_name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ),
        );

        return Snap::getSnapToken($params);
    }
}
