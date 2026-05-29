<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\ProductVariant;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $variant = ProductVariant::findOrFail($request->product_variant_id);

        // Cek stok cukup atau tidak
        if ($variant->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        // Cek apakah varian yang sama sudah ada di keranjang
        $cart = Cart::where('user_id', auth()->id())
                    ->where('product_variant_id', $request->product_variant_id)
                    ->first();

        if ($cart) {
            // Kalau sudah ada, tambah quantity-nya
            $cart->increment('quantity', $request->quantity);
        } else {
            // Kalau belum ada, buat baru
            Cart::create([
                'user_id' => auth()->id(),
                'product_variant_id' => $request->product_variant_id,
                'quantity' => $request->quantity,
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function index()
    {
        $carts = Cart::where('user_id', auth()->id())
                     ->with('variant.product')
                     ->get();

        return view('cart.index', compact('carts'));
    }

    public function remove($id)
    {
        Cart::where('id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        return back()->with('success', 'Produk dihapus dari keranjang!');
    }
}