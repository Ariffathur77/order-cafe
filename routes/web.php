<?php

use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StrukController;
use App\Livewire\Admin\OrderMonitor;
use App\Livewire\Customer\OrderStatusLivewire;
use App\Livewire\OrderLivewire;
use App\Models\Order;
use App\Models\Table;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/qrcodes', function () {
    return view('admin.qrcodes', [
        'tables' => \App\Models\Table::all()
    ]);
})->name('admin.qrcodes');

Route::get('/admin/orders', function () {
    $orders = Order::with('items.menu', 'table')->latest()->get();
    return view('admin.orders', compact('orders'));
})->name('admin.orders');

Route::get('/order/{slug}', function ($slug) {
    $table = Table::where('slug', $slug)->firstOrFail();
    return view('order', ['table' => $table]);
})->name('order.by-table');

Route::get('/order-monitor-page', function () {
    return view('order-monitor-page');
})->name('admin.order-monitor');

Route::get('/order-status/{uuid}', [OrderStatusController::class, 'show'])->name('order.status');
Route::get('/admin/struk/{order}', [StrukController::class, 'show'])->name('admin.struk.show');
Route::get('/meja/{table:slug}', OrderStatusLivewire::class)->name('customer.order.status');
Route::get('/struk/{order}', [StrukController::class, 'show'])->name('struk.show');
Route::post('/payment/token', [PaymentController::class, 'token'])->name('payment.token');

