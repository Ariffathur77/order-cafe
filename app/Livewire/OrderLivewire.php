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

    public function increaseQty($menuId)
    {
        if (isset($this->cart[$menuId])) {
            $this->cart[$menuId]['qty']++;
            session()->put("cart_{$this->table->id}", $this->cart);
        }
    }

    public function decreaseQty($menuId)
    {
        if (isset($this->cart[$menuId]) && $this->cart[$menuId]['qty'] > 1) {
            $this->cart[$menuId]['qty']--;
            session()->put("cart_{$this->table->id}", $this->cart);
        } else {
            // kalau qty sudah 1 dan dikurangin, hapus item
            unset($this->cart[$menuId]);
            session()->put("cart_{$this->table->id}", $this->cart);
        }
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
