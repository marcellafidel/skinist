<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderTrackingController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('details.variant.product')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.order-tracking.index', compact('orders'));
    }

    public function show($invoiceNumber)
    {
        $order = Order::where('invoice_number', $invoiceNumber)
            ->where('user_id', Auth::id())
            ->with(['details.variant.product', 'statusHistories.changedBy'])
            ->firstOrFail();

        return view('user.order-tracking.show', compact('order'));
    }

    public function cancel(Request $request, $invoiceNumber)
    {
        $order = Order::where('invoice_number', $invoiceNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (!$order->isCancellable()) {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }

        $request->validate([
            'cancel_reason' => 'required|string|max:255',
        ]);

        $order->update(['status' => 'cancelled']);
        $order->addStatusHistory('cancelled', $request->cancel_reason, Auth::id());

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function uploadPayment(Request $request, $invoiceNumber)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $order = Order::where('invoice_number', $invoiceNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        $order->update(['payment_proof' => $path]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload! Menunggu konfirmasi admin.');
    }
}