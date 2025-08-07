    @extends('components.layouts.app')

    @section('content')
        <div class="p-6 text-center">
            <h1 class="text-2xl font-bold mb-2">Status Pesanan Anda</h1>
            <p class="text-gray-500 mb-4">Meja: {{ $table->name }}</p>

            @if ($order)
                <div class="bg-white p-4 rounded shadow mb-4">
                    <p class="text-lg font-semibold">Nomor Pesanan: #{{ $order->id }}</p>
                    <p>Status:
                        <span class="text-blue-600 font-bold capitalize">
                            {{ $order->status }}
                        </span>
                    </p>
                </div>

                <h2 class="text-lg font-semibold mb-2">Daftar Pesanan</h2>
                <ul class="text-left inline-block">
                    @forelse ($order->items as $item)
                        <li>• {{ $item->menu->name ?? '[Menu dihapus]' }} x{{ $item->quantity }}</li>
                    @empty
                        <li>Tidak ada item pesanan.</li>
                    @endforelse
                </ul>
            @else
                <p class="text-gray-500">Belum ada pesanan dari meja ini.</p>
            @endif
        </div>
    @endsection
