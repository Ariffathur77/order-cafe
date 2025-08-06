<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Struk Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .struk {
            width: 300px;
            margin: auto;
            padding: 10px;
            border: 1px dashed #000;
        }

        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .item {
            display: flex;
            justify-content: space-between;
        }

        .total {
            font-weight: bold;
            font-size: 16px;
            margin-top: 10px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="struk">
        <div class="title">STRUK PESANAN</div>
        <div class="line"></div>

        <p>Meja: {{ $order->table->name }}</p>
        <p>Waktu: {{ $order->created_at->format('d/m/Y H:i') }}</p>

        <div class="line"></div>

        @foreach ($order->items as $item)
            <div class="item">
                <span>{{ $item->menu->name }} x{{ $item->quantity }}</span>
                <span>Rp {{ number_format($item->total_price, 0, ',', '.') }}</span>
            </div>
        @endforeach

        <div class="line"></div>

        <div class="item total">
            <span>Total</span>
            <span>Rp {{ number_format($order->items->sum('total_price'), 0, ',', '.') }}</span>
        </div>

        <div class="line"></div>

        <p class="text-center">Terima kasih!</p>
    </div>

    <div class="text-center no-print" style="margin-top: 20px;">
        <button onclick="window.print()">🖨️ Cetak</button>
        <a href="{{ url()->previous() }}">🔙 Kembali</a>
    </div>

</body>

</html>
