<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private function checkAdmin()
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Akses ditolak!');
        }
    }

    public function index()
    {
        $this->checkAdmin();
        $orders = Order::with(['user', 'details.variant.product'])
            ->latest()
            ->get();

        return view('admin.orders', compact('orders'));
    }

    public function show($id)
    {
        $this->checkAdmin();
        $order = Order::with(['user', 'details.variant.product', 'statusHistories.changedBy'])
            ->findOrFail($id);

        return view('admin.orders-show', compact('order'));
    }

    public function confirmPayment($id)
    {
        $this->checkAdmin();
        $order = Order::findOrFail($id);

        $order->update(['status' => 'paid']);
        $order->addStatusHistory('paid', 'Pembayaran dikonfirmasi oleh admin', Auth::id());

        return back()->with('success', 'Pembayaran dikonfirmasi!');
    }

    public function updateStatus(Request $request, $id)
    {
        $this->checkAdmin();

        $request->validate([
            'status' => 'required|in:pending,paid,shipped,delivered,cancelled',
            'note'   => 'nullable|string|max:255',
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->status;

        if ($oldStatus === $newStatus) {
            return back()->with('error', 'Status tidak berubah.');
        }

        if (in_array($oldStatus, ['delivered', 'cancelled'])) {
            return back()->with('error', 'Status pesanan sudah final, tidak bisa diubah.');
        }

        $order->update(['status' => $newStatus]);
        $order->addStatusHistory($newStatus, $request->note, Auth::id());

        return back()->with('success', 'Status pesanan diupdate!');
    }

    public function invoice($id)
    {
        $this->checkAdmin();
        $order = Order::where('id', $id)
            ->with('details.variant.product.brand', 'user')
            ->firstOrFail();

        return view('admin.invoice', compact('order'));
    }
}