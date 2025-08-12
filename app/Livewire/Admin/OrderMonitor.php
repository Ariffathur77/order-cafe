<?php

namespace App\Livewire\Admin;

use App\Models\Menu;
use App\Models\Order;
use Livewire\Component;

class OrderMonitor extends Component
{
    public $orders;
    public $lastOrderId;

    public function mount()
    {
        $this->orders = Order::with('table', 'items.menu')->latest()->get();

        $this->lastOrderId = $this->orders->first()?->id;
    }

    public function checkNewOrders()
    {
        $latestOrder = Order::with('table', 'items.menu')->latest()->first();

        if ($latestOrder && $latestOrder->id !== $this->lastOrderId) {
            // Ada order baru
            $this->lastOrderId = $latestOrder->id;
            $this->orders = Order::with('table', 'items.menu')->latest()->get();

            // Trigger sound di browser
            $this->dispatch('play-sound');
            $this->dispatch('showAlert', message: 'Ada pesanan baru masuk!');
        }
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
        // Ambil semua menu
        $menus = Menu::all();

        $this->checkNewOrders();

        return view('livewire.admin.order-monitor', [
            'orders' => Order::latest()->get(),
        ]);
    }
}
