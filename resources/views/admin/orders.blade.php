@extends('components.layouts.app')
@section('content')
    <div class="p-6">
        <h1 class="text-xl font-bold mb-4">Daftar Pesanan Masuk</h1>

        <table class="w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">#</th>
                    <th class="border px-4 py-2">Meja</th>
                    <th class="border px-4 py-2">Total Item</th>
                    <th class="border px-4 py-2">Total Harga</th>
                    <th class="border px-4 py-2">Waktu</th>
                    <th class="border px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2">{{ $order->table->name }}</td>
                        <td class="border px-4 py-2">{{ $order->items->sum('quantity') }}</td>
                        <td class="border px-4 py-2">Rp
                            {{ number_format($order->items->sum('total_price'), 0, ',', '.') }}
                        </td>
                        <td class="border px-4 py-2">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('admin.struk.show', $order->id) }}" class="text-blue-600 hover:underline"
                                target="_blank">
                                🖨️ Cetak Struk
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
