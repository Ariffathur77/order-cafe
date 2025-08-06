<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class StrukController extends Controller
{
    public function show(Order $order)
    {
        return view('admin.struk', compact('order'));
    }
}
