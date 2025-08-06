<?php

namespace App\Livewire;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

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
        if (empty($this->cart)) {
            session()->flash('error', 'Keranjang kosong.');
            return;
        }

        DB::beginTransaction();

        try {
            $order = Order::create([
                'uuid' => Str::uuid(),
                'table_id' => $this->table->id,
                'total' => $this->calculateTotal(),
            ]);

            foreach ($this->cart as $menuId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $menuId,
                    'quantity' => $item['qty'],
                    'total_price' => $item['qty'] * $item['price'],
                ]);
            }

            DB::commit();

            // Reset cart
            $this->cart = [];
            session()->forget("cart_{$this->table->id}");

            session()->flash('success', 'Pesanan berhasil dikirim.');

        } catch (\Throwable $e) {
            DB::rollback();
            session()->flash('error', 'Terjadi kesalahan saat menyimpan pesanan.');
        }
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
