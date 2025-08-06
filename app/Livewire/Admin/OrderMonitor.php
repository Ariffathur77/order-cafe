<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;

class OrderMonitor extends Component
{
    public $orders;

    public function mount()
    {
        $this->orders = Order::with('table', 'items.menu')->latest()->get();
    }

    public function markAsProcessed($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->status = 'processed';
        $order->save();

        $this->mount(); // refresh list
    }

    public function markAsDone($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->status = 'done';
        $order->save();

        $this->mount(); // refresh list
    }

    public function render()
    {
        return view('livewire.admin.order-monitor');
    }
}
