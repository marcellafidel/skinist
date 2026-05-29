<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
                       ->with('details.variant.product')
                       ->latest()
                       ->get();

        return view('orders.index', compact('orders'));
    }
}