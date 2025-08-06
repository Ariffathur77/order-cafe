<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Status Pesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-md mx-auto bg-white rounded p-6 shadow">
        <h1 class="text-xl font-bold text-center mb-4">Status Pesanan</h1>

        <p><strong>No. Order:</strong> {{ $order->uuid }}</p>
        <p><strong>Meja:</strong> {{ $order->table->name }}</p>
        <p><strong>Status:</strong>
            <span class="font-semibold text-blue-600">
                {{ ucfirst($order->status) }}
            </span>
        </p>
        <p class="mt-2"><strong>Daftar Item:</strong></p>
        <ul class="list-disc pl-5">
            @foreach ($order->items as $item)
                <li>{{ $item->menu->name }} x{{ $item->quantity }}</li>
            @endforeach
        </ul>
        <p class="mt-4 font-bold text-right">Total: Rp {{ number_format($order->item->sum('total_price')) }}</p>
        <a href="{{ route('struk.show', $order->id) }}"
            class="mt-6 block text-center bg-green-600 text-white font-semibold py-2 px-4 rounded hover:bg-green-700 transition">
            🔖 Lihat Struk Pesanan
        </a>
    </div>
</body>

</html>
