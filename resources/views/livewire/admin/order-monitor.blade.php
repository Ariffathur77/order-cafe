    <div wire:poll.5s class="p-4 space-y-4 max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Monitoring Pesanan</h1>

        @forelse ($orders as $order)
            <div class="border rounded shadow p-4 bg-white">
                <div class="flex justify-between items-center mb-2">
                    <div>
                        <h2 class="font-semibold">Meja: {{ $order->table->name ?? '-' }}</h2>
                        <p class="text-sm text-gray-600">Status:
                            <span class="font-medium text-blue-600">{{ ucfirst($order->status) }}</span>
                        </p>
                        <p class="text-sm text-gray-500">Waktu: {{ $order->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="space-x-2">
                        @if ($order->status === 'pending')
                            <button wire:click="markAsProcessed({{ $order->id }})"
                                class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                Proses
                            </button>
                        @endif

                        @if ($order->status === 'processed')
                            <button wire:click="markAsDone({{ $order->id }})"
                                class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                Selesai
                            </button>
                        @endif
                    </div>
                </div>

                <ul class="pl-4 list-disc text-sm text-gray-700">
                    @foreach ($order->items as $item)
                        <li>
                            {{ $item->menu->name ?? '-' }} x{{ $item->quantity }}
                            - Rp {{ number_format($item->menu->price * $item->quantity, 0, ',', '.') }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @empty
            <div class="text-center text-gray-500 py-10">
                Tidak ada pesanan terbaru.
            </div>
        @endforelse
    </div>
