@extends('components.layouts.app')

@section('content')
    <div class="p-6">
        <h1 class="text-xl font-bold mb-4">Order untuk Meja: {{ $table->name }}</h1>
        @livewire('order-livewire', ['table' => $table])
    </div>
@endsection
