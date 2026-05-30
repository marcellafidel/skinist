<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Cek apakah sudah pernah review produk ini
        $existing = Review::where('user_id', auth()->id())
                          ->where('product_id', $productId)
                          ->first();

        if ($existing) {
            return back()->with('error', 'Kamu sudah pernah memberikan ulasan untuk produk ini!');
        }

        Review::create([
            'product_id' => $productId,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Ulasan berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $review = Review::where('id', $id)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();
        $review->delete();
        return back()->with('success', 'Ulasan berhasil dihapus!');
    }
}