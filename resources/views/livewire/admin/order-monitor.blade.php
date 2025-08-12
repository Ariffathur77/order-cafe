    <div wire:poll.5s="checkNewOrders" class="p-4 space-y-4 max-w-4xl mx-auto">
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

                        @if ($order->status === 'done')
                            <div class="flex justify-content-center items-center text-green-600 font-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Selesai
                            </div>
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
                <div x-data="{ show: false, message: '' }" x-show="show" x-text="message"
                    class="fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded shadow-lg transition-opacity duration-500"
                    x-transition style="display: none;" x-init="window.addEventListener('showAlert', event => {
                        message = event.detail.message;
                        show = true;
                        setTimeout(() => show = false, 3000); // Hilang setelah 3 detik
                    });"></div>

                <script>
                    // window.addEventListener('playSound', () => {
                    //     document.getElementById('notifSound').play();
                    // });
                    window.addEventListener('showAlert', event => {
                        // Tampilkan toast
                        let toast = document.createElement('div');
                        toast.innerText = event.detail.message;
                        toast.className = "fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded shadow";
                        document.body.appendChild(toast);

                        // Hapus setelah 3 detik
                        setTimeout(() => {
                            toast.remove();
                        }, 3000);

                        // Putar suara
                        let audio = new Audio('/sounds/notif.wav');
                        audio.play().catch(err => console.log("Suara gagal diputar:", err));
                    });
                </script>
            </div>
        @empty
            <div class="text-center text-gray-500 py-10">
                Tidak ada pesanan terbaru.
            </div>
        @endforelse
    </div>
