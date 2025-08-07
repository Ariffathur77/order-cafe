<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    public function show($uuid)
    {
        $order = Order::where('uuid', $uuid)->with('items.menu', 'table')->firstOrFail();

        return view('livewire.customer.order-status-livewire', [
            'order' => $order,
            'table' => $order->table,
        ]);
    }
}
