<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Notification;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', auth()->id())
                     ->with('variant.product')
                     ->get();

        return view('checkout.index', compact('carts'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
        ]);

        $carts = Cart::where('user_id', auth()->id())
                     ->with('variant')
                     ->get();

        if ($carts->isEmpty()) {
            return back()->with('error', 'Keranjang kamu kosong!');
        }

        try {
            DB::transaction(function () use ($carts, $request) {

                // Hitung total harga
                $total = $carts->sum(function ($cart) {
                    return $cart->variant->price * $cart->quantity;
                });

                // Hitung diskon kupon
                $discount = 0;
                if (session('coupon_id')) {
                    $coupon = \App\Models\Coupon::find(session('coupon_id'));
                    if ($coupon && $coupon->isValid($total)) {
                        $discount = $coupon->calculateDiscount($total);
                        $coupon->increment('used_count');
                        session()->forget(['coupon_code', 'coupon_id']);
                    }
                }
                $finalTotal = $total - $discount;

                // Buat order baru
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'invoice_number' => 'INV-' . strtoupper(uniqid()),
                    'total_price' => $finalTotal,
                    'status' => 'pending',
                    'shipping_address' => $request->shipping_address,
                ]);

                // Buat order detail & kurangi stok
                foreach ($carts as $cart) {
                    if ($cart->variant->stock < $cart->quantity) {
                        throw new \Exception('Stok ' . $cart->variant->shade_name . ' tidak mencukupi!');
                    }

                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_variant_id' => $cart->product_variant_id,
                        'quantity' => $cart->quantity,
                        'price' => $cart->variant->price,
                    ]);

                    $cart->variant->decrement('stock', $cart->quantity);
                }

                // Kosongkan keranjang
                Cart::where('user_id', auth()->id())->delete();

                // Kirim notifikasi
                Notification::create([
                    'user_id' => auth()->id(),
                    'title' => 'Pesanan Berhasil Dibuat! 🎉',
                    'message' => 'Pesanan kamu dengan invoice ' . $order->invoice_number . ' senilai Rp ' . number_format($finalTotal, 0, ',', '.') . ' sedang menunggu pembayaran.',
                    'type' => 'success',
                ]);
            });

            return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}