<?php

namespace App\Livewire;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;
use Midtrans\Config;
use Midtrans\Snap;

class OrderLivewire extends Component
{
    public $table;
    public $menus;
    public $cart = [];

    public function mount(Table $table)
    {
        $this->table = $table;
        $this->menus = Menu::all();

        $this->cart = session()->get("cart_{$this->table->id}", []);
    }

    public function addToCart($menuId)
    {
        $menu = Menu::findOrFail($menuId);

        if (isset($this->cart[$menuId])) {
            $this->cart[$menuId]['qty']++;
        } else {
            $this->cart[$menuId] = [
                'menu' => $menu->name,
                'price' => $menu->price,
                'qty' => 1,
            ];
        }

        // Simpan ulang ke session
        session()->put("cart_{$this->table->id}", $this->cart);
    }

    public function removeFromCart($menuId)
    {
        unset($this->cart[$menuId]);

        session()->put("cart_{$this->table->id}", $this->cart);
    }

    public function placeOrder()
    {
        // Validasi keranjang
        if (empty($this->cart)) {
            session()->flash('message', 'Keranjang kosong.');
            return;
        }

        // Simpan order
        $order = Order::create([
            'uuid' => Str::uuid(),
            'table_id' => $this->table->id,
            'status' => 'pending', // atau sesuai enum kamu
            'total_price' => collect($this->cart)->sum(fn($item) => $item['qty'] * $item['price']),
        ]);

        // Simpan item
        foreach ($this->cart as $menuId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $menuId,
                'quantity' => $item['qty'],
                'price' => $item['price'],
                'total_price' => $item['qty'] * $item['price'],
            ]);
        }

        // Bersihkan keranjang
        session()->forget("cart_{$this->table->id}");
        $this->reset('cart');

        // Redirect ke halaman status pesanan
        return redirect()->route('customer.order.status', ['table' => $this->table->slug]);
    }

    public function payWithMidtrans()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $orderId = 'ORDER-' . now()->timestamp;
        $grossAmount = $this->calculateTotal();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'enabled_payments' => ['qris'],
        ];

        $snapUrl = Snap::createTransaction($params)->redirect_url;

        return redirect()->away($snapUrl);
    }

    private function calculateTotal()
    {
        $total = 0;
        foreach ($this->cart as $item) {
            $total += $item['price'] * $item['qty'];
        }
        return $total;
    }

    public function render()
    {
        return view('livewire.order-livewire');
    }
}
