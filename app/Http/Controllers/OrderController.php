<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function invoice($id)
    {
        $order = Order::where('id', $id)
                    ->where('user_id', auth()->id())
                    ->with('details.variant.product.brand')
                    ->firstOrFail();

        return view('orders.invoice', compact('order'));
    }
}