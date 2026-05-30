<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $coupon = Coupon::where('code', strtoupper($request->coupon_code))->first();

        if (!$coupon) {
            return back()->with('coupon_error', 'Kode kupon tidak ditemukan!');
        }

        // Hitung total cart
        $carts = \App\Models\Cart::where('user_id', auth()->id())
                                  ->with('variant')
                                  ->get();
        $total = $carts->sum(fn($c) => $c->variant->price * $c->quantity);

        if (!$coupon->isValid($total)) {
            if ($total < $coupon->min_purchase) {
                return back()->with('coupon_error', 'Minimal pembelian Rp ' . number_format($coupon->min_purchase, 0, ',', '.') . ' untuk menggunakan kupon ini!');
            }
            return back()->with('coupon_error', 'Kupon tidak valid atau sudah kadaluarsa!');
        }

        // Simpan kupon ke session
        session(['coupon_code' => $coupon->code, 'coupon_id' => $coupon->id]);

        $discount = $coupon->calculateDiscount($total);
        return back()->with('coupon_success', 'Kupon berhasil dipakai! Diskon Rp ' . number_format($discount, 0, ',', '.'));
    }

    public function remove()
    {
        session()->forget(['coupon_code', 'coupon_id']);
        return back()->with('coupon_success', 'Kupon berhasil dihapus!');
    }
}