<?php

namespace App\Livewire\Customer;

use App\Models\Table;
use Livewire\Component;

class OrderStatusLivewire extends Component
{
    public $table;
    public $order;

    public function mount(Table $table)
    {
        $this->table = $table;

        // Ambil pesanan terakhir dari meja ini
        $this->order = $table->orders()->latest()->first();
    }

    public function render()
    {
        return view('livewire.customer.order-status-livewire')->layout('components.layouts.app');
    }
}
