@extends('components.layouts.app')
@section('content')
    <h1 class="text-2xl font-bold mb-4">QR Code Meja</h1>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach ($tables as $table)
            <div class="bg-white p-4 rounded shadow text-center">
                <h2 class="font-semibold mb-2">{{ $table->name }}</h2>
                <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ urlencode(route('order.by-table', $table->slug)) }}&amp;size=150x150"
                    alt="QR {{ $table->name }}" class="mx-auto mb-2">
                <p class="text-sm break-words">{{ route('order.by-table', $table->slug) }}</p>
            </div>
        @endforeach
    </div>
@endsection
