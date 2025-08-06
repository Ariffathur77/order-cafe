<!DOCTYPE html>
<html>

<head>
    <title>Struk Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow p-6 rounded w-full max-w-md">
        <h1 class="text-center text-lg font-bold mb-4">Struk Pemesanan</h1>
        <p><strong>Meja:</strong> {{ $order->table->name }}</p>
        <p><strong>Status:</strong> {{ $order->status->label() }}</p>
        <hr class="my-2">

        <ul>
            @foreach ($order->items as $item)
                <li class="flex justify-between">
                    <span>{{ $item->menu->name }} x{{ $item->quantity }}</span>
                    <span>Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</span>
                </li>
            @endforeach
        </ul>

        <hr class="my-2">
        <p class="text-right font-bold">
            Total: Rp
            {{ number_format($order->item->sum(fn($item) => $item->quantity * $item->price), 0, ',', '.') }}
        </p>

        <div class="mt-4 text-center">
            <a href="/" class="text-blue-500 underline">Kembali ke halaman utama</a>
        </div>
    </div>
</body>

</html>
