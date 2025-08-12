<div wire:poll.10s class="p-4 max-w-3xl mx-auto bg-gray-50 min-h-screen">
    <!-- Judul Halaman -->
    <h1 class="text-2xl font-bold text-center mb-6">Pesan untuk: {{ $table->name }}</h1>

    <!-- Logo -->
    <div class="flex justify-center mb-6">
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo">
    </div>

    <!-- Notifikasi Berhasil -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-6">
            {{ session('message') }}
        </div>
    @endif

    <!-- Daftar Menu -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
        @foreach ($menus as $menu)
            <div class="border p-4 rounded shadow hover:bg-gray-100 transition duration-200">
                <img src="{{ asset('storage/' . $menu->image) }}" alt="" class="w-full h-32 object-cover mb-2">
                <h2 class="text-lg font-semibold">{{ $menu->name }}</h2>
                <p class="text-gray-600 mb-2">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                <button wire:click="addToCart({{ $menu->id }})"
                    class="w-full px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Tambah
                </button>
            </div>
        @endforeach
    </div>

    <!-- Keranjang -->
    <h2 class="text-xl font-semibold mb-3">Keranjang</h2>
    <div class="bg-white p-4 border rounded shadow-sm mb-6">
        @forelse ($cart as $id => $item)
            <div class="flex justify-between items-center mb-2 border-b pb-2">
                <div>
                    <p class="font-medium">{{ $item['menu'] }}</p>
                    <div class="flex items-center gap-2 mt-1">
                        <button wire:click="decreaseQty({{ $id }})"
                            class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">-</button>
                        <span>{{ $item['qty'] }}</span>
                        <button wire:click="increaseQty({{ $id }})"
                            class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">+</button>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-semibold">Rp {{ number_format($item['qty'] * $item['price']) }}</p>
                    <button wire:click="removeFromCart({{ $id }})"
                        class="text-sm text-red-500 hover:underline">
                        Hapus
                    </button>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Keranjang kosong.</p>
        @endforelse
    </div>


    <!-- Tombol QRIS -->
    <button wire:click="payWithMidtrans" wire:loading.attr="disabled" wire:target="payWithMidtrans"
        class="bg-green-500 text-white px-4 py-2 rounded">
        Bayar dengan QRIS
    </button>



    <div class="text-right font-bold text-lg mb-4">
        Total: Rp {{ number_format(array_sum(array_map(fn($item) => $item['qty'] * $item['price'], $cart))) }}
    </div>

    <!-- Tombol Kirim -->
    @if ($cart)
        <div class="text-center mt-4">
            <button wire:click="placeOrder"
                class="px-6 py-2 bg-green-600 text-white font-semibold rounded hover:bg-green-700 transition">
                Kirim Pesanan
            </button>
        </div>
    @endif
</div>
