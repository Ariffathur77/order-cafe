<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

class PaymentController extends Controller
{
    public function token(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        dd($serverKey);
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = false; // true kalau sudah live
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $order_id = $request->order_id;
        $gross_amount = (int) $request->gross_amount;

        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $gross_amount,
            ],
            'qris' => [
                'acquirer' => 'gopay' // atau bisa dikosongkan
            ]
        ];

        $snapToken = Snap::getSnapToken($params);
        return response()->json(['token' => $snapToken]);
    }
}
