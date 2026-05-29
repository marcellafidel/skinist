<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminController extends Controller
{
    public function orders()
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Akses ditolak!');
        }

        $orders = Order::with(['user', 'details.variant.product'])
                       ->latest()
                       ->get();

        return view('admin.orders', compact('orders'));
    }

    public function confirmPayment($id)
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Akses ditolak!');
        }

        $order = Order::findOrFail($id);
        $order->update(['status' => 'paid']);

        return back()->with('success', 'Pembayaran dikonfirmasi!');
    }

    public function updateStatus(Request $request, $id)
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Akses ditolak!');
        }

        $request->validate([
            'status' => 'required|in:pending,paid,shipped,delivered,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan diupdate!');
    }
}