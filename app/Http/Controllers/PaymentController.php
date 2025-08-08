<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

class PaymentController extends Controller
{
    public function token(Request $request)
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $request->order_id,
                'gross_amount' => (int) $request->gross_amount,
            ],
            'enabled_payments' => ['qris'],
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json(['token' => $snapToken]);
    }
}
