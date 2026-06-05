<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::where('user_id', auth()->id())
                             ->with('product.brand', 'product.variants')
                             ->get();
        return view('wishlist', compact('wishlists'));
    }

    public function toggle($productId)
    {
        $existing = Wishlist::where('user_id', auth()->id())
                            ->where('product_id', $productId)
                            ->first();

        if ($existing) {
            $existing->delete();
            $wishlisted = false;
        } else {
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $productId,
            ]);
            $wishlisted = true;
        }

        if (request()->wantsJson()) {
            return response()->json(['wishlisted' => $wishlisted]);
        }

        return back()->with('success', $wishlisted ? 'Produk ditambahkan ke wishlist!' : 'Produk dihapus dari wishlist!');
    }
}